<?php

trait WithGetSchemaCalculator {

    /**
     * @param EducationForm $educationForm
     * @param $service
     * @return IPaymentCalculator
     */
    public function getSchemaCalculator(EducationForm $educationForm, $service='course') {
        $schemes= array();

        $param = Yii::app()->session["lg"]?$service."_title_".Yii::app()->session["lg"]:$service."_title_ua";
        foreach ($this->schemes as $scheme){
            $schema = new AdvancePaymentSchema($scheme->discount, $scheme->loan, $scheme->pay_count, $educationForm, $scheme->id, $scheme->schemeName->$param);
            array_push($schemes,$schema);
        }

        return $schemes;
    }

    public function getActualAdvancePaymentSchemaCalculator($courseId,EducationForm $educationForm) {
        $serviceModel = CourseService::model()->getService($courseId, $educationForm);
        $schemas = PaymentScheme::model()->getPaymentScheme(null, $serviceModel);
        $scheme=TemplateSchemes::model()->findByAttributes(array('id_template'=>$schemas->id_template,'pay_count'=>1));
        $actualAdvancePaymentSchema = new AdvancePaymentSchema($scheme->discount, $scheme->loan, $scheme->pay_count, $educationForm, $scheme->id,$scheme->schemeName->course_title_ua);

        return $actualAdvancePaymentSchema;
    }
}