<?php


// The helper class takes the data from the CSV file and transform the data into an JSON object ready to display on the front-end.
class Helper
{
    private $arrayProperties = array(); // Array used to store properties and hotels information.  

    private $arrayRooms = array(); // Array used to store rooms information.
        
    private $array = array(); // Used to store information of the property, rooms and hotels temporaly before to be pushed to either $arrayProperties or $arrayRooms.

    private $arrayId = array(); // It is used to store all the hotels and property ids.

    private $property = NULL; // Set to NULL initially, but it becomes true if the property is not registered on the $arrayProperties, otherwise false.
    
    // The transform methods take an array with strings from the CSV file creates two arrays, the first one (arrayProperties) for the properties and hotels and 
    // the second one (arrayRooms) array for the rooms. Then it compares the arrays, and if the id matches, it inserts the room information into the property array. Finally, retuns the array to the front-end

    public function transform($data)
    {

        foreach ($data as $indexArr => $arr)
        {
            foreach($arr as $index => $val){
           
               $this->setId($index, $val);
               $this->setName($index, $val);
               $this->setPostcode($index, $val);
               $this->setType($index, $val);
               $this->setPropId($index, $val);
               $this->setPrice($index, $val);
               $this->setRating($index, $val);
               
            }
            if(!empty($this->array) && !$this->property){
                array_push($this->arrayRooms , $this->array);
            }elseif($this->array){
                array_push($this->arrayProperties, $this->array);
            }
            $this->array = array();
        }
          $this->insertRooms();
          return $this->arrayProperties; 
    }

 // The setId method is in charge of setting the id for the properties and hotels and linking the rooms with them. 
 // It is in control of the $property, which prevents the room data from being stored as something different.
    private function setId($index, $val){

        if( !in_array($val,$this->arrayId) && $index === 0){
            array_push($this->arrayId,$val);
            $this->array['id'] = intval($val);
            $this->property = TRUE;  
        }elseif(in_array($val,$this->arrayId) && $index === 0){
            $this->property = FALSE;
            $this->array['belongs_id'] =$val;

        }
    }   
    
// The setName method is in charge of setting the name for the properties and hotels and room name for the rooms. 
    private function setName($index, $val){
        if( $index === 1 && $this->property ){
            $this->array['property_name'] =$val;
        }elseif($index === 1 && !$this->property ){
            $this->array['room_name'] =$val;
        }
    }
    
// The setPostcode method is in charge of setting the postcode for the properties and hotels.
    private function setPostcode($index, $val){

        if( $index === 2 && $this->property ){
            $this->array['property_postcode'] =$val;
        }
    }
// The setType method is in charge of setting the type for the properties and hotels.
    private function setType($index, $val){
         
        if($index === 3 && $val !=='rooms' && $this->property ){
            $this->array['rooms'] =[];
        }
    }
// The setPropId method is in charge of setting the property_id for the rooms. 
    private function setPropId($index, $val){
         
        if($index === 4 && !$this->property ){
            $this->array['id'] = $val;
        }
    }
// The setPrice method is in charge of setting the price for the rooms. 
    private function setPrice($index, $val){
         
        if($index === 5 && !$this->property ){
            $this->array['price_per_week'] = strval($val);
        }
    }
// The setRating method is in charge of setting the rating for the rooms.
    private function setRating($index, $val){
         
        if($index === 6 && !$this->property ){
            $this->array['rating'] = $val;
        }
    }

// The orderArray method reindex a given array.
    private function orderArray(&$array, $a, $b) {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        $array = array_merge($p2,$p1,$array);
    }
// The insertRooms method inserts the rooms array into the rooms array within the arrayProperties.
    private function insertRooms() {
        foreach($this->arrayProperties as $index => $val){
            foreach($this->arrayRooms as $index2 => $val2){
                if($val['id'] == $val2['belongs_id']){
                    array_shift($val2);
                    $this->orderArray($val2 , 1, 0);
                    array_push($this->arrayProperties[$index]['rooms'] , $val2);
                }
            }
        }
    }

}