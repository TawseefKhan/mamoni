<?php

class Api extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        //$this->reset();
        //$this->del();
        //$this->dh_satelliteclinic();
        //$this->dh_inventory();
        //$this->dh_familyplan();
    }
    
    function delete(){
        //$this->reset();
        if(isset($_GET["pass"]))
            if($_GET["pass"]=="mazharul_islam")
                $this->del();
    }
    
    function sync() {        
        
       RequestValidate::validateSyncRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        //sent the valid request to model
        $syncRequest = new SyncRequest();
        if((isset($_POST["data"]["get_all"]))&&($_POST["data"]["get_all"]=="true"))
            $syncRequest->run($user, "0", $_POST["data"]["get_all"]);
        else
             $syncRequest->run($user, $_POST["data"]["timestamp"]);
        
        ApiEncode::printJson($syncRequest->getArrays());
         
        //ob_clean();
        //var_dump($_POST["data"]);
    }
    
    function form() {
        RequestValidate::validateFormRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        //sent the valid request to model a
        $formRequest = new FormRequest();
        $formRequest->run($user, $_POST["data"]["requests"]);
        ApiEncode::printJson($formRequest->getArrays());
    }
    
    private function del(){
        $db = Database::get();
        $datas = $db->select("select * from forms");
        
        foreach ($datas as $data){
            FormRepository::delete($data["id"]);
        }
    }
    
    /*Not complete*/
    private function dh_antinantals(){
        $datas = array(
            "name" => "dh_antenantals",
            "fields" =>array(
                "patientid" => array(
                    "type" => "number"
                ),
                "bloodpressure" => array(
                    "type" => "bool"
                ),
                "hemoglobintest" => array(
                    "type" => "bool"
                ),
                "urinetest" => array(
                    "type" => "bool"
                ),
                "pregnancyfood" => array(
                    "type" => "bool"
                ),
                "pregnancydanger" => array(
                    "type" => "bool"
                ),
                "fourparts" => array(
                    "type" => "bool"
                ),
                "delivery" => array(
                    "type" => "bool"
                ),
                "feedbaby" => array(
                    "type" => "bool"
                ),
                "sixmonths" => array(
                    "type" => "bool"
                ),
                "familyplanning" => array(
                    "type" => "bool"
                ),
                "folictablet" => array(
                    "type" => "bool"
                ),
                "folictabletimportance" => array(
                    "type" => "bool"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );  
        SchemaDefine::create($datas);
    }
      
    private function dh_sickchild(){
        $datas = array(
            "name" => "dh_sickchild",
            "fields" =>array(
                "facility_id" => array(
                    "type" => "number"
                ),
                "sp_client" => array(
                    "type" => "text"
                ),
                "sp_designation" => array(
                    "type" => "text"
                ),
                "seral_no" => array(
                    "type" => "number"
                ),
                "form_date" => array(
                    "type" => "text"
                ),
                "start_time" => array(
                    "type" => "text"
                ),
                "child_description" => array(
                    "type" => "text"
                ),
                "age" => array(
                    "type" => "number"
                ),
                "feed" => array(
                    "type" => "bool"
                ),
                "vomit" => array(
                    "type" => "bool"
                ),
                "stutter" => array(
                    "type" => "bool"
                ),
                "cough" => array(
                    "type" => "bool"
                ),
                "diaria" => array(
                    "type" => "bool"
                ),
                "fever" => array(
                    "type" => "bool"
                ),
                "measure_fever" => array(
                    "type" => "bool"
                ),
                "stethoscope" => array(
                    "type" => "bool"
                ),
                "breathing_test" => array(
                    "type" => "bool"
                ),
                "eye_test" => array(
                    "type" => "bool"
                ),
                "infected_mouth" => array(
                    "type" => "bool"
                ),
                "neck" => array(
                    "type" => "bool"
                ),
                "ear" => array(
                    "type" => "bool"
                ),
                "hand" => array(
                    "type" => "bool"
                ),
                "dehydration" => array(
                    "type" => "bool"
                ),
                "weight" => array(
                    "type" => "bool"
                ),
                "clinic_test" => array(
                    "type" => "bool"
                ),
                "belly_button" => array(
                    "type" => "bool"
                ),
                "height" => array(
                    "type" => "bool"
                ),
                "result" => array(
                    "type" => "textarray"
                ),
                "end_time" => array(
                    "type" => "text"
                )
                ,
                "village" => array(
                    "type" => "text"
                )
                ,
                "union" => array(
                    "type" => "text"
                )
                ,
                "district" => array(
                    "type" => "text"
                )
                ,
                "sub_district" => array(
                    "type" => "text"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );  
        SchemaDefine::create($datas);
    }
    
    private function dh_satelliteclinic(){
        $datas = array(
            "name" => "dh_satelliteclinic",
            "fields" =>array(
                "facility_id" => array(
                    "type" => "number"
                ),
                "sp_name" => array(
                    "type" => "text"
                ),
                "sp_designation" => array(
                    "type" => "text"
                ),
                "client_name" => array(
                    "type" => "text"
                ),
                "form_date" => array(
                    "type" => "text"
                ),
                "start_time" => array(
                    "type" => "text"
                ),
                "waiting_place" => array(
                    "type" => "bool"
                ),
                "furniture" => array(
                    "type" => "bool"
                ),
                "test_place" => array(
                    "type" => "bool"
                ),
                "privacy" => array(
                    "type" => "bool"
                ),
                "testing_bed" => array(
                    "type" => "bool"
                ),
                "testing_chair" => array(
                    "type" => "bool"
                ),
                "toilet" => array(
                    "type" => "bool"
                ),
                "adult_wing" => array(
                    "type" => "bool"
                ),
                "child_wing" => array(
                    "type" => "bool"
                ),
                "infant_wing" => array(
                    "type" => "bool"
                ),
                "height_rod" => array(
                    "type" => "bool"
                ),
                "measuring_tip" => array(
                    "type" => "bool"
                ),
                "blood_pressure_mechine" => array(
                    "type" => "bool"
                ),
                "stethoscope" => array(
                    "type" => "bool"
                ),
                "filter_stethoscope" => array(
                    "type" => "bool"
                ),
                "thermometer" => array(
                    "type" => "bool"
                ),
                "chart_line" => array(
                    "type" => "bool"
                ),
                "vaginal_speculum" => array(
                    "type" => "bool"
                ),
                "cotton_ball" => array(
                    "type" => "bool"
                ),
                "disposable_syringe" => array(
                    "type" => "bool"
                ),
                "water" => array(
                    "type" => "bool"
                ),
                "hand_spoap" => array(
                    "type" => "bool"
                ),
                "spirit" => array(
                    "type" => "bool"
                ),
                "waste_receptacle" => array(
                    "type" => "bool"
                ),
                "sharp_waste" => array(
                    "type" => "bool"
                ),
                "gloves" => array(
                    "type" => "bool"
                ),
                "test_tube" => array(
                    "type" => "bool"
                ),
                "test_tube_holder" => array(
                    "type" => "bool"
                ),
                "test_tube_rack" => array(
                    "type" => "bool"
                ),
                "dipstick" => array(
                    "type" => "bool"
                ),
                "telecoet_book" => array(
                    "type" => "bool"
                ),
                "telecoet_lanstet" => array(
                    "type" => "bool"
                ),
                "iron_folate" => array(
                    "type" => "bool"
                ),
                "calcium" => array(
                    "type" => "bool"
                ),
                "misoprostol" => array(
                    "type" => "bool"
                ),
                "amoxycillin" => array(
                    "type" => "bool"
                ),
                "sukhi" => array(
                    "type" => "bool"
                ),
                "apon" => array(
                    "type" => "bool"
                ),
                "condom" => array(
                    "type" => "bool"
                ),
                "injectable" => array(
                    "type" => "bool"
                ),
                "card" => array(
                    "type" => "bool"
                ),
                "pictured_items" => array(
                    "type" => "bool"
                ),
                "end_time" => array(
                    "type" => "text"
                )
                ,
                "village" => array(
                    "type" => "text"
                )
                ,
                "union" => array(
                    "type" => "text"
                )
                ,
                "district" => array(
                    "type" => "text"
                )
                ,
                "sub_district" => array(
                    "type" => "text"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );  
        SchemaDefine::create($datas);
    }
    
    private function dh_inventory(){
        $datas = array(
            "name" => "dh_inventory",
            "fields" =>array(
                "facility_id" => array(
                    "type" => "number"
                ),
                "client_name" => array(
                    "type" => "text"
                ),
                "start_time" => array(
                    "type" => "text"
                ),
                "instrument_sp_name" => array(
                    "type" => "text"
                ),
                "instrument_sp_designation" => array(
                    "type" => "text"
                ),
                "i_electronic_autoclev" => array(
                    "type" => "intarray"
                ),
                "i_non_electronic_autoclev" => array(
                    "type" => "intarray"
                ),
                "i_electric_sterilizer" => array(
                    "type" => "intarray"
                ),
                "i_electric_steamer" => array(
                    "type" => "intarray"
                ),
                "i_non_electric_pot" => array(
                    "type" => "intarray"
                ),
                "i_stove" => array(
                    "type" => "intarray"
                ),
                "i_waste_sp_name" => array(
                    "type" => "text"
                ),
                "i_waste_sp_designation" => array(
                    "type" => "text"
                ),
                "w_waste_option" => array(
                    "type" => "textarray"
                ),
                "w_waste_dispose_how" => array(
                    "type" => "textarray"
                ),
                "w_pointy_waste" => array(
                    "type" => "textarray"
                ),
                "w_liquid_waste" => array(
                    "type" => "textarray"
                ),
                "w_liquid_waste_store" => array(
                    "type" => "textarray"
                ),
                "w_plastic_waste" => array(
                    "type" => "textarray"
                ),
                "w_waste_normal" => array(
                    "type" => "textarray"
                ),
                "w_incinerator" => array(
                    "type" => "number"
                ),
                "w_dumping_pit" => array(
                    "type" => "number"
                ),
                "w_incinerator_seen" => array(
                    "type" => "textarray"
                ),
                "w_dumping_pit_seen" => array(
                    "type" => "textarray"
                ),
                "equipment_sp_name" => array(
                    "type" => "text"
                ),
                "equipment_sp_designation" => array(
                    "type" => "text"
                ),
                "n_adult_wing_scale" => array(
                    "type" => "intarray"
                ),
                "n_height_rod" => array(
                    "type" => "intarray"
                ),
                "n_pressure_mechine" => array(
                    "type" => "intarray"
                ),
                "n_stethoscope" => array(
                    "type" => "intarray"
                ),
                "n_filter_stethoscope" => array(
                    "type" => "intarray"
                ),
                "n_water" => array(
                    "type" => "number"
                ),
                "n_hand_soap" => array(
                    "type" => "number"
                ),
                "n_spirit" => array(
                    "type" => "number"
                ),
                "n_waste" => array(
                    "type" => "number"
                ),
                "n_sharp_waste" => array(
                    "type" => "number"
                ),
                "n_gloves" => array(
                    "type" => "number"
                ),
                "n_iron_folate" => array(
                    "type" => "number"
                ),
                "n_urine_protien" => array(
                    "type" => "intarray"
                ),
                "n_urine_tester" => array(
                    "type" => "number"
                ),
                "n_urine_testtube" => array(
                    "type" => "number"
                ),
                "n_test_tube_rack" => array(
                    "type" => "number"
                ),
                "n_dip_stick" => array(
                    "type" => "number"
                ),
                "n_hemoglobin" => array(
                    "type" => "intarray"
                ),
                "n_telecoil_book" => array(
                    "type" => "number"
                ),
                "n_telecoil_landset" => array(
                    "type" => "number"
                ),
                "n_kolori_meter" => array(
                    "type" => "number"
                ),
                "n_litmus_paper" => array(
                    "type" => "number"
                ),
                "delivery_sp_name" => array(
                    "type" => "text"
                ),
                "delivery_sp_designation" => array(
                    "type" => "text"
                ),
                "d_delivery_table" => array(
                    "type" => "intarray"
                ),
                "d_pressure_mechine" => array(
                    "type" => "intarray"
                ),
                "d_stethoscope" => array(
                    "type" => "intarray"
                ),
                "d_filter_stethoscope" => array(
                    "type" => "intarray"
                ),
                "d_newborn_recuscitation" => array(
                    "type" => "intarray"
                ),
                "d_recuscitation_mask_0" => array(
                    "type" => "intarray"
                ),
                "d_recuscitation_mask_1" => array(
                    "type" => "intarray"
                ),
                "d_peguin_sucker" => array(
                    "type" => "intarray"
                ),
                "d_cord_cutter" => array(
                    "type" => "number"
                ),
                "d_cord_clamp" => array(
                    "type" => "number"
                ),
                "d_partograf_paper" => array(
                    "type" => "number"
                ),
                "d_water" => array(
                    "type" => "number"
                ),
                "d_hand_soap" => array(
                    "type" => "number"
                ),
                "d_spirit" => array(
                    "type" => "number"
                ),
                "d_waste_recycle" => array(
                    "type" => "number"
                ),
                "d_waste_storage" => array(
                    "type" => "number"
                ),
                "d_latex_gloves" => array(
                    "type" => "number"
                ),
                "d_chlorine_sol" => array(
                    "type" => "number"
                ),
                "d_detergent_water" => array(
                    "type" => "number"
                ),
                "d_clean_water" => array(
                    "type" => "number"
                ),
                "d_misoprostol" => array(
                    "type" => "number"
                ),
                "d_oxytocin" => array(
                    "type" => "number"
                ),
                "d_mang_sulfate" => array(
                    "type" => "number"
                ),
                "d_chlorhexidine" => array(
                    "type" => "number"
                ),
                "d_paediatric_drop" => array(
                    "type" => "number"
                ),
                "d_gentamycin" => array(
                    "type" => "number"
                ),
                "ch_wing_scale" => array(
                    "type" => "intarray"
                ),
                "ch_infant_wing_scale" => array(
                    "type" => "intarray"
                ),
                "ch_height_rod" => array(
                    "type" => "intarray"
                ),
                "ch_measuring_tip" => array(
                    "type" => "number"
                ),
                "ch_water" => array(
                    "type" => "number"
                ),
                "ch_growth_monitor_boy" => array(
                    "type" => "number"
                ),
                "ch_growth_monitor_girl" => array(
                    "type" => "number"
                ),
                "ch_hand_soap" => array(
                    "type" => "number"
                ),
                "ch_spirit" => array(
                    "type" => "number"
                ),
                "ch_wastage_recycle" => array(
                    "type" => "number"
                ),
                "ch_sharp_waste" => array(
                    "type" => "number"
                ),
                "ch_latex_gloves" => array(
                    "type" => "number"
                ),
                "ch_ors" => array(
                    "type" => "number"
                ),
                "ch_paediatric_drop" => array(
                    "type" => "number"
                ),
                "ch_cotrimoxazole" => array(
                    "type" => "number"
                ),
                "ch_paracetamol" => array(
                    "type" => "number"
                ),
                "ch_zinc" => array(
                    "type" => "number"
                ),
                "ch_mebandazole" => array(
                    "type" => "number"
                ),
                "ch_ceftriaxone" => array(
                    "type" => "number"
                ),
                "ch_vitamin" => array(
                    "type" => "number"
                ),
                "fp_soap" => array(
                    "type" => "number"
                ),
                "fp_spirit" => array(
                    "type" => "number"
                ),
                "fp_waste_recycle" => array(
                    "type" => "number"
                ),
                "fp_sharp_waste" => array(
                    "type" => "number"
                ),
                "fp_latex_gloves" => array(
                    "type" => "number"
                ),
                "r_healthy_newborn" => array(
                    "type" => "textarray"
                ),
                "r_newborn_death" => array(
                    "type" => "textarray"
                ),
                "r_mother_rate" => array(
                    "type" => "textarray"
                ),
                "r_elampsia" => array(
                    "type" => "textarray"
                ),
                "r_mang_sulfate" => array(
                    "type" => "textarray"
                ),
                "r_pneumonis" => array(
                    "type" => "textarray"
                ),
                "r_paracetamol" => array(
                    "type" => "textarray"
                ),
                "r_psbi" => array(
                    "type" => "textarray"
                ),
                "r_psbi_care" => array(
                    "type" => "textarray"
                ),
                "r_starving_child" => array(
                    "type" => "textarray"
                ),
                "r_starving_protocol" => array(
                    "type" => "textarray"
                ),
                "end_time" => array(
                    "type" => "text"
                )
                ,
                "village" => array(
                    "type" => "text"
                )
                ,
                "union" => array(
                    "type" => "text"
                )
                ,
                "district" => array(
                    "type" => "text"
                )
                ,
                "sub_district" => array(
                    "type" => "text"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );
        SchemaDefine::create($datas);
    }
    
    private function dh_familyplan(){
         $datas = array(
            "name" => "dh_familyplan",
            "fields" =>array(
                "facility_id" => array(
                    "type" => "number"
                ),
                "sp_name" => array(
                    "type" => "text"
                ),
                "sp_designation" => array(
                    "type" => "text"
                ),
                "client_name" => array(
                    "type" => "text"
                ),
                "serial_no" => array(
                    "type" => "number"
                ),
                "date" => array(
                    "type" => "text"
                ),
                "start_time" => array(
                    "type" => "text"
                ),
                "concent" => array(
                    "type" => "text"
                ),
                "cover" => array(
                    "type" => "bool"
                ),
                "sound_prove" => array(
                    "type" => "bool"
                ),
                "discuss_fp" => array(
                    "type" => "bool"
                ),
                "discuss_fp_protocol" => array(
                    "type" => "bool"
                ),
                "questions" => array(
                    "type" => "bool"
                ),
                "job_aid" => array(
                    "type" => "bool"
                ),
                "followup" => array(
                    "type" => "bool"
                ),
                "end_time" => array(
                    "type" => "text"
                )
                ,
                "village" => array(
                    "type" => "text"
                )
                ,
                "union" => array(
                    "type" => "text"
                )
                ,
                "district" => array(
                    "type" => "text"
                )
                ,
                "sub_district" => array(
                    "type" => "text"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );  
        SchemaDefine::create($datas);
    }
        
    
    function login(){
        RequestValidate::validateLoginRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        $r = new Response();
        $r->status = 2;
        $r->message="Correct login and pass";
        
        $arr = $r->getArray();
        $arr["type"] = $user->type;
        
        ApiEncode::printJson($arr);
    }
        
}