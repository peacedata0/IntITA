<?php
/**
 * Created by PhpStorm.
 * User: Ivanna
 * Date: 13.05.2015
 * Time: 15:33
 */
$headerText = Yii::t('mainpage','0002');
$subheaderText = Yii::t('mainpage','0006');
$dropName = Yii::t('mainpage','0004');
?>
<div class="fullpageaboutus">
    <div class="mainAboutBlock">
        <div class="mainAbout">
            <div class="header" id="anchorAboutUs">
                <?php echo $headerText; ?>
                <p>
                    <?php echo $subheaderText; ?>
                </p>
            </div>

            <div class="line1">
                <img src="<?php echo StaticFilesHelper::createPath('image', 'aboutus', 'line1.png');?>">
            </div>

            <?php
            $index=0;
            $anchor=0;
            foreach ($massAbout as $val)
            {
                $index++;

                ?>
                <div class="block" id="<?php echo AboutUsHelper::getIdTabAboutUs($index) ?>" onclick="showAboutUs('<?php echo $index ?>',this)">
                    <ul>
                        <li>
                            <div class="icon">
                                <img src="<?php echo $val->iconImage;?>">
                            </div>
                            <div class="title" >
                                <div class="aboutTitleLink" >
                                    <?php echo $val->titleTextExp; ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            <?php
            }
            ?>

            <! Script for Drop Down text>
            <script type="text/javascript">
                var width=0;
                if (self.screen)
                {
                    width = screen.width
                }
                function centerPage()
                {
                    $('.contentCenterBox').css('width', width);
                    $('.contentCenterBox').css('left', "50%");
                    $('.contentCenterBox').css('margin-left', -width/2);
                }
                function Window()
                {
                    $('#dropTextLayer1').css('display', 'inline-block');
                }
                function WindowShow(buttonNumber,anchor)
                {
                    if (anchor==1)
                    {
                        $("body").animate({"scrollTop":440},"fast");
                    }
                    if (buttonNumber ==1)
                    {
                        $('#dropTextLayer1').css('display', 'inline-block');
                        $('#dropTextLayer2').css('display', 'none');
                        $('#dropTextLayer3').css('display', 'none');
                        $('#firstblock').addClass('selectedTab');
                    }
                    if (buttonNumber ==2)
                    {
                        $('#dropTextLayer2').css('display', 'inline-block');
                        $('#dropTextLayer1').css('display', 'none');
                        $('#dropTextLayer3').css('display', 'none');
                        $('#secondblock').addClass('selectedTab');
                    }
                    if (buttonNumber ==3)
                    {
                        $('#dropTextLayer3').css('display', 'inline-block');
                        $('#dropTextLayer2').css('display', 'none');
                        $('#dropTextLayer1').css('display', 'none');
                        $('#threeblock').addClass('selectedTab');
                    }
                }

                function showAboutUs(buttonNumber,block)
                {
                    if (buttonNumber ==1)
                    {
                        $('#dropTextLayer1').css('display', 'inline-block');
                        $('#dropTextLayer2').css('display', 'none');
                        $('#dropTextLayer3').css('display', 'none');
                        $('.block').removeClass('selectedTab');
                        $(block).addClass('selectedTab');
                        $('body,html').animate({scrollTop: $("#anchorAboutUs").offset().top}, 400);
                    }
                    if (buttonNumber ==2)
                    {
                        $('#dropTextLayer2').css('display', 'inline-block');
                        $('#dropTextLayer1').css('display', 'none');
                        $('#dropTextLayer3').css('display', 'none');
                        $('.block').removeClass('selectedTab');
                        $(block).addClass('selectedTab');
                        $('body,html').animate({scrollTop: $("#anchorAboutUs").offset().top}, 400);
                    }
                    if (buttonNumber ==3)
                    {
                        $('#dropTextLayer3').css('display', 'inline-block');
                        $('#dropTextLayer2').css('display', 'none');
                        $('#dropTextLayer1').css('display', 'none');
                        $('.block').removeClass('selectedTab');
                        $(block).addClass('selectedTab');
                        $('body,html').animate({scrollTop: $("#anchorAboutUs").offset().top}, 400);
                    }
                }
            </script>

    <!--        <! buttons for dropdown  About Us>-->
    <!--        <div id="dropButton1" onclick="WindowShow(1)" >-->
    <!--            --><?php // echo  $dropName;   ?>
    <!--        </div>-->
    <!--        <div id="dropButton2" onclick="WindowShow(2)">-->
    <!--            --><?php // echo  $dropName;   ?>
    <!--        </div>-->
    <!--        <div id="dropButton3" onclick="WindowShow(3)">-->
    <!--            --><?php // echo  $dropName;   ?>
    <!--        </div>-->


        </div>
    </div>
</div>