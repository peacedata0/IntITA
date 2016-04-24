<?php

class RevisionController extends Controller {
    public $layout = 'revisionlayout';

    public function init()
    {
        $app = Yii::app();
        if (isset($app->session['lg'])) {
            $app->language = $app->session['lg'];
        }
        if (Yii::app()->user->isGuest) {
            $this->render('/site/authorize');
            die();
        } else return true;
    }

    public function actionIndex() {
        if (!$this->isUserApprover(Yii::app()->user)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $lectureRev = RevisionLecture::model()->with("properties")->findAll();
        $lecturesTree = RevisionLecture::getLecturesTree();

        $json = $this->buildLectureTreeJson($lectureRev, $lecturesTree);

        $this->render('index', array(
            'json' => $json
        ));
    }

    public function actionCreateNewLecture() {

        $idModule = Yii::app()->request->getPost("idModule");
        $order = Yii::app()->request->getPost("order");
        $titleUa = Yii::app()->request->getPost("titleUa");
        $titleEn = Yii::app()->request->getPost("titleEn");
        $titleRu = Yii::app()->request->getPost("titleRu");

        if (!$this->isUserTeacher(Yii::app()->user, $idModule)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $revLecture = RevisionLecture::createNewLecture($idModule, $order, $titleUa, $titleEn, $titleRu, Yii::app()->user);

        $this->redirect(array('revision/editlecturerevision', 'idRevision' => $revLecture->id_revision));
    }

    public function actionEditLectureRevision($idRevision) {

        $lectureRevision = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRevision)) {
            throw new RevisionControllerException(403, 'У тебе немає прав для редагування цієї ревізії');
        }

        if (!$lectureRevision->isEditable()) {
            throw new RevisionControllerException(400, 'This lecture cannot be modified.');
        }
        $this->render("lectureview", array(
            "lectureRevision" => $lectureRevision,
            "idRevision" => $idRevision,
            "pages" => $lectureRevision->lecturePages
        ));
    }

    public function actionPreviewLectureRevision($idRevision) {

        $lectureRevision = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        if (!$this->isUserTeacher(Yii::app()->user, $lectureRevision->id_module) && !$this->isUserApprover(Yii::app()->user, $lectureRevision->id_module)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $this->render("lecturePreview/lectureview", array(
            "lectureRevision" => $lectureRevision,
            "idRevision" => $idRevision,
            "pages" => $lectureRevision->lecturePages
        ));
    }

    public function actionAddPage() {

        $idRevision = Yii::app()->request->getPost("idRevision");

        $lectureRevision = RevisionLecture::model()->with('properties')->findByPk($idRevision);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRevision)) {
            throw new CHttpException(403, 'Access denied.');
//            throw new RevisionControllerException(403, 'Access denied.');
        }

        $newPage = $lectureRevision->addPage(Yii::app()->user);

        $json = json_encode(array(
            "id" => $newPage->id,
            "title" => $newPage->page_title,
            "order" => $newPage->page_order,
        ));

        echo $json;
    }

    public function actionNewPageRevision() {

        $idPage = Yii::app()->request->getPost("idPage");

        $pageRevision = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($pageRevision->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $newRevision = $pageRevision->clonePage();
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionEditPageRevision($idPage) {

        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $video = $page->getVideo();
        $lectureBody = $page->getLectureBody();
        $dataProvider = new CArrayDataProvider($lectureBody);
        $quiz = $page->getQuiz();

        $this->render("indexCKE", array(
            'user' => Yii::app()->user->getId(),
            "page" => $page,
            "video" => $video,
            "dataProvider" => $dataProvider,
            "quiz" => $quiz));
    }

    public function actionAddVideo() {

        $idPage = Yii::app()->request->getPost("idPage");
        $url = Yii::app()->request->getPost("url");

        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->saveVideo($url);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionEditPageTitle() {
        $idPage = Yii::app()->request->getPost("idPage");
        $title = Yii::app()->request->getPost("title");
        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->setTitle($title);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAddLectureElement() {
        $idPage = Yii::app()->request->getPost('idPage');
        $idType = Yii::app()->request->getPost('idType');
        $html_block = Yii::app()->request->getPost('html_block');

        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->addTextBlock($idType, $html_block);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionGetLectureElement() {
        $idEl = Yii::app()->request->getPost('idElement');
        $html = RevisionLectureElement::model()->findByPk($idEl)->html_block;
        echo $html;
    }

    public function actionEditLectureElement() {
        $idElement = Yii::app()->request->getPost('idElement');
        $html_block = Yii::app()->request->getPost('html_block');

        $element = RevisionLectureElement::model()->findByPk($idElement);

        $page = RevisionLecturePage::model()->findByPk($element->id_page);
        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $element->html_block = $html_block;
        if (trim($element->html_block) == '')
            echo Yii::t('lecture', '0814');
        else
            $element->saveCheck();
    }

    /**
     * curl -XPOST --data 'idPage=2' 'http://intita.project/revision/UpPage' -b XDEBUG_SESSION=PHPSTORM
     * @throws RevisionControllerException
     */
    public function actionUpPage() {
        $idPage = Yii::app()->request->getPost('idPage');

        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->moveUp();
    }

    public function actionDownPage() {
        $idPage = Yii::app()->request->getPost('idPage');

        $page = RevisionLecturePage::model()->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->moveDown();
    }

    public function actionCheckLecture() {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $lectureRevision = RevisionLecture::model()->with('lecturePages')->findByPk($idRevision);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRevision)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $result = $lectureRevision->checkConflicts();

        if (empty($result)) {
            echo "Конфліктів не виявлено!";
            return;
        } else {
            echo implode("; ", $result);
            return;
        }
    }

    public function actionSendForApproveLecture() {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $lectureRev = RevisionLecture::model()->with('lecturePages', 'properties')->findByPk($idRevision);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRev)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $result = $lectureRev->checkConflicts();

        if (empty($result)) {
            $lectureRev->sendForApproval(Yii::app()->user);
        } else {
            echo implode("; ", $result);
        }
    }
    public function actionCancelSendForApproveLecture() {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $lectureRev = RevisionLecture::model()->with('lecturePages', 'properties')->findByPk($idRevision);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRev)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $lectureRev->cancelSendForApproval();
    }

    public function actionRejectLectureRevision() {

        if (!$this->isUserApprover(Yii::app()->user)) {
            throw new RevisionControllerException(403, 'Access denied. You have not privileges to reject a lecture');
        }

        $idRevision = Yii::app()->request->getPost('idRevision');
        $lectureRev = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        $lectureRev->reject(Yii::app()->user);

    }

    public function actionCancelLectureRevision () {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $lectureRev = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idLecture);

        if (!$this->isUserEditor(Yii::app()->user, $lectureRev)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }
        $lectureRev->cancel(Yii::app()->user);
    }

    /**
     * curl -XPOST --data 'idLecture=126' 'http://intita.project/revision/ApproveLectureRevision' -b XDEBUG_SESSION=PHPSTORM
     * @throws Exception
     * @throws RevisionControllerException
     */
    public function actionApproveLectureRevision() {

        if (!$this->isUserApprover(Yii::app()->user)) {
            throw new RevisionControllerException(403, 'Access denied. You have not privileges to approve a lecture');
        }

        $idRevision = Yii::app()->request->getPost('idRevision');
        $lectureRev = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        $lectureRev->approve(Yii::app()->user);
    }

    public function actionUpLectureElement() {
        $idPage = Yii::app()->request->getPost('idPage');
        $idElement = Yii::app()->request->getPost('idElement');

        $page = RevisionLecturePage::model()->with('lectureElements')->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->upElement($idElement);
    }

    public function actionDownLectureElement() {
        $idPage = Yii::app()->request->getPost('idPage');
        $idElement = Yii::app()->request->getPost('idElement');

        $page = RevisionLecturePage::model()->with('lectureElements')->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->downElement($idElement);
    }

    public function actionDeleteLectureElement() {
        $idPage = Yii::app()->request->getPost('idPage');
        $idElement = Yii::app()->request->getPost('idElement');

        $page = RevisionLecturePage::model()->with('lectureElements')->findByPk($idPage);

        if (!$this->isUserEditor(Yii::app()->user, RevisionLecture::model()->findByPk($page->id_revision))) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $page->deleteElement($idElement);
    }

    /**
     * curl -XGET 'http://intita.project/revision/EditLecture?idLecture=104' -b XDEBUG_SESSION=PHPSTORM
     * @param $idLecture
     * @throws Exception
     * @throws RevisionControllerException
     */

    public function actionEditLecture($idLecture) {

        $lectureRev = RevisionLecture::model()->findByAttributes(array("id_lecture" => $idLecture));
        $lecture = Lecture::model()->findByPk($idLecture);

        if (!$this->isUserTeacher(Yii::app()->user, $lecture->idModule)) {
            throw new RevisionControllerException(403, 'Access denied. You have not privileges to view lecture.');
        }

        if ($lectureRev == null) {
            $lectureRev = RevisionLecture::createNewRevisionFromLecture($lecture, Yii::app()->user);
        }

        $relatedRev = $lectureRev->getRelatedLectures();
        $relatedTree = RevisionLecture::getLecturesTree($lecture->idModule);
        $json = $this->buildLectureTreeJson($relatedRev, $relatedTree);

        $this->render('index', array(
            'json' => $json,
        ));
    }

    public function actionDeleteLecture() {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $idModule = Yii::app()->request->getPost('idModule');
        $user = Yii::app()->user;
        $lecture = Lecture::model()->findByPk($idLecture);

        $lectureRev = RevisionLecture::model()->findByAttributes(array("id_lecture" => $idLecture));

        if (!$this->isUserTeacher($user, $lecture->idModule)) {
            throw new RevisionControllerException(403, 'Access denied. You have not privileges to delete lecture.');
        }

        if ($lectureRev == null) {
            $lectureRev = RevisionLecture::createNewRevisionFromLecture($lecture, $user);
        }

        $lectureRev->cancel($user);
        $lectureRev->deleteLectureFromRegularDB();

        $relatedRev = $lectureRev->getRelatedLectures();
        $relatedTree = RevisionLecture::getLecturesTree($lecture->idModule);
        $json = $this->buildLectureTreeJson($relatedRev, $relatedTree);

        $this->render('index', array(
            'json' => $json,
        ));
    }

    public function actionModuleLecturesRevisions($idModule) {

        $lectureRev = RevisionLecture::model()->findAllByAttributes(array("id_module" => $idModule));
        $relatedTree = RevisionLecture::getLecturesTree($idModule);
        $json = $this->buildLectureTreeJson($lectureRev, $relatedTree);

        $this->render('index', array(
            'idModule' => $idModule,
            'json' => $json,
        ));
    }

    public function actionShowRevision($idRevision) {
        $lectureRev = RevisionLecture::model()->with('properties, lecturePages')->findByPk($idRevision);

    }

    /**
     * curl -XPOST --data 'revisionId=138&pageId=691&idType=12&condition=condition&testTitle=testTitle&optionsNum=2&answer1=answer1&is_valid1=1&answer2=answer2&is_valid2=0' 'http://intita.project/revision/addtest' -b XDEBUG_SESSION=PHPSTORM
     * @return bool|null
     * @throws CDbException
     * @throws RevisionLectureElementException
     */

    public function actionAddTest() {
        $revisionId = Yii::app()->request->getPost('revisionId');
        $pageId = Yii::app()->request->getPost('pageId');
        $idType = Yii::app()->request->getPost('idType');

        $htmlBlock = Yii::app()->request->getPost('condition', '');
        $optionsNum = Yii::app()->request->getPost('optionsNum', 0); //options amount

        $quiz = [];
        $quiz['testTitle'] = Yii::app()->request->getPost('testTitle', '');
        $options = [];
        for ($i = 0; $i < $optionsNum; $i++) {
            $options[$i]["answer"] = Yii::app()->request->getPost("answer" . ($i + 1), '');
            $options[$i]["is_valid"] = Yii::app()->request->getPost("is_valid" . ($i + 1), 0);
        }
        $quiz['answers'] = $options;


        $lectureRevision = RevisionLecture::model()->findByPk($revisionId);

        $lectureRevision->addLectureElement($pageId, ['idType' => $idType,
            'html_block' => $htmlBlock,
            'quiz' => $quiz]);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * curl -XPOST --data 'revisionId=138&pageId=691&idBlock=756&condition=condition2&testTitle=testTitle2&optionsNum=2&answer1=answer3&answer2=answer4&is_valid2=1' 'http://intita.project/revision/EditTest' -b XDEBUG_SESSION=PHPSTORM
     */
    public function actionEditTest() {

        $revisionId = Yii::app()->request->getPost('revisionId');
        $pageId = Yii::app()->request->getPost('pageId');
        $lectureElementId = Yii::app()->request->getPost('idBlock');

        $htmlBlock = Yii::app()->request->getPost('condition', '');
        $optionsNum = Yii::app()->request->getPost('optionsNum', 0);    //options amount

        $quiz = [];
        $quiz['testTitle'] = Yii::app()->request->getPost('testTitle', '');     //RevisionTest->title

        $options = [];
        for ($i = 0; $i < $optionsNum; $i++) {
            $options[$i]["answer"] = Yii::app()->request->getPost("answer" . ($i + 1), '');     //RevisionTestAnswer->answer
            $options[$i]["is_valid"] = Yii::app()->request->getPost("is_valid" . ($i + 1), 0);  //RevisionTestAnswer->is_valid
        }

        $quiz['answers'] = $options;

        $lectureRevision = RevisionLecture::model()->findByPk($revisionId);

        $lectureRevision->editLectureElement($pageId, [
            'id_block' => $lectureElementId,
            'html_block' => $htmlBlock,
            'quiz' => $quiz
        ]);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * curl -XPOST --data 'revisionId=138&pageId=691&idBlock=757' 'http://intita.project/revision/DeleteTest'  -b XDEBUG_SESSION=PHPSTORM
     */
    public function actionDeleteTest() {
        $revisionId = Yii::app()->request->getPost('revisionId');
        $pageId = Yii::app()->request->getPost('pageId');
        $idBlock = Yii::app()->request->getPost('idBlock', 0);

        $lectureRevision = RevisionLecture::model()->findByPk($revisionId);
        $lectureRevision->deleteLectureElement($pageId, $idBlock);
    }

    /**
     * curl -XPOST --data 'idRevision=99' 'http://intita.project/revision/CloneLecture' -b XDEBUG_SESSION=PHPSTORM
     */
    public function actionCloneLecture() {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $lectureRevision = RevisionLecture::model()->findByPk($idRevision);

        $lectureRevision->cloneLecture(Yii::app()->user);
    }

    /**
     *  curl -XPOST --data 'idPage=588' 'http://intita.project/revision/DeletePage' -b XDEBUG_SESSION=PHPSTORM
     */
    public function actionDeletePage() {
        $idPage = Yii::app()->request->getPost('idPage');
        $page = RevisionLecturePage::model()->findByPk($idPage);
        $page->delete();
    }

    /**
     * Returns true if $user can approve or reject.
     * @param $user
     * @return bool
     * @throws CDbException
     */
    private function isUserApprover($user) {
        return RegisteredUser::userById($user->getId())->canApprove();
    }

    /**
     * Returns true if $user can edit $lecture (if the $user created the $lecture)
     * @param $user
     * @param RevisionLecture $lectureRev
     * @return mixed
     */
    private function isUserEditor($user, $lectureRev) {
        return ($lectureRev->properties->id_user_created == $user->getId());
    }

    /**
     * Returns true if $user is belongs to module teachers.
     * @param $user
     * @param $idModule
     * @return bool
     */
    private function isUserTeacher($user, $idModule) {
        return Teacher::isTeacherAuthorModule($user->getId(), $idModule);
    }

    /**
     * Function to build tree of lectures based on quickUnion data structure
     * @param $tree - tree to build, passed by reference
     * @param $node - node to add
     * @param $parents - quik union structre
     */
    private function appendNode(&$tree, $node, $parents) {
        if ($parents[$node['id']] == $node['id']) {
            //if root node
            $tree[$node['id']] = $node;
        } else {
            $path = [];
            $parentId = $parents[$node['id']];

            //building path from root to target node
            array_push($path, $parentId);
            while ($parents[$parentId] != $parentId) {
                array_push($path, $parents[$parentId]);
                $parentId = $parents[$parentId];
            }

            //finding reference to target node
            $targetNode = &$tree;
            while (count($path) != 0) {
                if (!array_key_exists('nodes', $targetNode)) {
                    $targetNode =& $targetNode[array_pop($path)];
                } else {
                    $targetNode =& $targetNode['nodes'][array_pop($path)];
                }
            }

            //adding node to 'nodes' array in target node
            if (!array_key_exists('nodes', $targetNode)) {
                $targetNode['nodes'] = array();
            }
            $targetNode['nodes'][$node['id']] = $node;
        }
    }

    private function buildLectureTreeJson($lectures, $lectureTree) {
        $jsonArray = [];
        foreach ($lectures as $lecture) {
            $node = array();
            $node['text'] = "Ревізія №" . $lecture->id_revision . " " . $lecture->properties->title_ua . ". Статус: " . $lecture->getStatus();
            $node['selectable'] = false;
            $node['id'] = $lecture->id_revision;

            $this->appendNode($jsonArray, $node, $lectureTree);
        }
        return json_encode(array_values($jsonArray));
    }

    public function actionDataTest() {
        $idPage = Yii::app()->request->getPost('idPage');
        $page = RevisionLecturePage::model()->findByPk($idPage);
        $data = [];
        $data["condition"] =  $page->getQuiz()->html_block;
        $answers=RevisionTests::getTestAnswers($page->quiz);
        $valid=RevisionTestsAnswers::getTestValid($page->quiz);
        $data["answers"]=$answers;
        $data["valid"]=$valid;

        echo CJSON::encode($data);
    }

    public function actionLecturePages() {
        $idRevision = Yii::app()->request->getPost('idRevision');
        $lectureRevision = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);
        $editor = $this->isUserEditor(Yii::app()->user, $lectureRevision);
        $editable = $lectureRevision->isEditable();
        $data = [];
        foreach ($lectureRevision->lecturePages as $key => $page) {
            $data[$key]["id"] = $page->id;
            $data[$key]["page_title"] = $page->page_title;
            $data[$key]["page_order"] = $page->page_order;
            $data[$key]["editor"] = $editor;
            $data[$key]["editable"] = $editable;
        }
        echo CJSON::encode($data);
    }

    /**
     * Legacy methods
     *
     */

    public function actionCreateNewBlock() {
        $pageOrder = Yii::app()->request->getPost('page');
        $idType = Yii::app()->request->getPost('type');
        $htmlBlock = Yii::app()->request->getPost('editorAdd');
        $idLecture = Yii::app()->request->getPost('idLecture');

        $lecture = Lecture::model()->findByPk($idLecture);

        $lecture->createNewBlock($htmlBlock, $idType, $pageOrder, Yii::app()->user->getId());

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteElement() {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $order = Yii::app()->request->getPost('order');

        $lecture = Lecture::model()->with("lectureEl")->findByPk($idLecture);

        $lecture->deleteLectureElement($order, Yii::app()->user->getId());

        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionSaveBlock() {
        $order = Yii::app()->request->getPost('order');
        $idLesson = Yii::app()->request->getPost('idLecture');
        $content = str_replace("\n</p>", "</p>", Yii::app()->request->getPost('content'));

        $lesson = Lecture::model()->findByPk($idLesson);

        $lesson->saveBlock($order, $content, Yii::app()->user->getId());
    }

    public function actionDeleteVideo() {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $pageOrder = Yii::app()->request->getPost('pageOrder');

        $lecture = Lecture::model()->findByPk($idLecture);

        $lecture->deleteVideo($pageOrder, Yii::app()->user->getId());

        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->request->urlReferrer);
    }

    //reorder blocks on lesson page - up block

    public function actionUpElement() {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $order = Yii::app()->request->getPost('order');

        $lecture = Lecture::model()->findByPk($idLecture);

        $lecture->upElement($order);

        // if AJAX request, we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->request->urlReferrer);
    }

    //reorder blocks on lesson page - down block

    public function actionDownElement() {
        $idLecture = Yii::app()->request->getPost('idLecture');
        $order = Yii::app()->request->getPost('order');

        $lecture = Lecture::model()->findByPk($idLecture);

        $lecture->downElement($order);

        // if AJAX request, we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionCreateLectureRevision($idRevision) {

        $lectureRevision = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        if (!$this->isUserTeacher(Yii::app()->user, $lectureRevision->id_module)) {
            throw new RevisionControllerException(403, 'Access denied.');
        }

        $lectureRevision = $lectureRevision->cloneLecture(Yii::app()->user);
        if($lectureRevision){
            $this->redirect(Yii::app()->createUrl('/revision/EditLectureRevision',array('idRevision'=>$lectureRevision->id_revision)));
        }else{
            throw new RevisionControllerException(500, 'CreateLectureRevision error');
        }
    }

    public function actionGetRevisionPreviewData()
    {
        $idRevision = Yii::app()->request->getPost('idRevision');

        $lectureRevision = RevisionLecture::model()->with("properties", "lecturePages")->findByPk($idRevision);

        $pages = [];
        $lecture = [];
        $data = array('lecture' => array(),'pages' => array());
        foreach ($lectureRevision->lecturePages as $key=>$page) {
            $pages[$key]["id"] = $page->id;
            $pages[$key]['title'] = $page->page_title;
            $pages[$key]["page_order"] = $page->page_order;
        }
        $lecture['status']=$lectureRevision->getStatus();
        $lecture['canEdit']=$lectureRevision->canEdit();
        $lecture['canSendForApproval']=$lectureRevision->canSendForApproval();
        $lecture['canCancelSendForApproval']=$lectureRevision->canCancelSendForApproval();
        $lecture['canApprove']=$lectureRevision->canApprove();
        $lecture['canCancelRevision']=$lectureRevision->canCancelRevision();
        $lecture['canRejectRevision']=$lectureRevision->canRejectRevision();

        $data['lecture']=$lecture;
        $data['pages']=$pages;
        echo CJSON::encode($data);
    }
    public function actionVideoPreview()
    {
        $idRevision = $_GET['idRevision'];
        $idPage = $_GET['idPage'];

        $page = RevisionLecturePage::model()->findByAttributes(array("id_revision" => $idRevision, "page_order" => $idPage));

        echo $this->renderPartial('lecturePreview/_videoTab',
            array('page' => $page), true);
    }
    public function actionTextPreview()
    {
        $idRevision = $_GET['idRevision'];
        $idPage = $_GET['idPage'];

        $page = RevisionLecturePage::model()->findByAttributes(array("id_revision" => $idRevision, "page_order" => $idPage));

        $dataProvider = new CArrayDataProvider($page->getLectureBody());

        echo $this->renderPartial('lecturePreview/_textTab',
            array('data' => $dataProvider->getData()), true);
    }
    public function actionQuizPreview()
    {
        $idRevision = $_GET['idRevision'];
        $idPage = $_GET['idPage'];

        $page = RevisionLecturePage::model()->findByAttributes(array("id_revision" => $idRevision, "page_order" => $idPage));
        $quiz = $page->getQuiz();
        echo $this->renderPartial('lecturePreview/_quiz',
            array('quiz' => $quiz), true);
    }
    public function actionCheckTestAnswer()
    {
        $emptyanswers = [];
        $test =  Yii::app()->request->getPost('test', '');
        $answers = Yii::app()->request->getPost('answers', $emptyanswers);

        echo RevisionTestsAnswers::checkTestAnswer($test, $answers);
    }
}