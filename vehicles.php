<?php
class Vehicles {
  const CSVDELIMITER = ',';
  const VEHICLES_LIST = 'http://cossettehalifax.com/8060afb6-2a32-46b8-b1a8-1a291e8f8f11/vehicles.csv';

  public function createFile() {
    $vinArray = $this->_parseCSV();

    foreach ($vinArray as $vinItem) {
      $newFile = $vinItem[2] . ".html";
      
      if(!file_exists($newFile)) {
        $head = $this->_createHead($vinItem);
        $vehicleTxt = $this->_createVehicleText($vinItem);
        $vehicleImages = $this->_createMainImage($vinItem);
        $additionalImages = $this->_createAdditionalImages($vinItem);
        $footer = $this->_createFooter();
        $vehicleContent = $head . $vehicleImages . $vehicleTxt . $additionalImages . $footer;

        file_put_contents($newFile, $vehicleContent);
      }
    }
  }

  public function indexLinks() {
    $vinArray = $this->_parseCSV();
    $linkArray = array();

    foreach ($vinArray as $vinItem) {
      $linkArray[] = $vinItem[2] . ".html";
    }
    return $linkArray;
  }

  private function _parseCSV() {
    $vinArray = array();

    if (($handle = fopen(self::VEHICLES_LIST, "r")) !== FALSE) {
      while (($csvRow = fgetcsv($handle, self::CSVDELIMITER)) !== FALSE) {
        $vinNum = $csvRow[2];

        if(0 === strpos($vinNum, '2')) {
          $vinArray[] = $csvRow;
        }
      }
      return $vinArray;
      fclose($handle);
    }
  }

  private function _createVehicleText($vehicleInfo) {
    $vehicleText = "<div class='vehicle-text-container'>" .
    "<h1>" . $vehicleInfo[4] . " - " . $vehicleInfo[5] . " (" . $vehicleInfo[3] . ")</h1>" .
    "<h3>Car Info</h3>" .
    "<ul>" .
    "<li>" . $vehicleInfo[6] .  "</li>" .
    "<li>" . $vehicleInfo[10] .  "</li>" .
    "<li>" . $vehicleInfo[2] .  "</li>" .
    "</ul>" . 
    "</div>";

    return $vehicleText;
  }

  private function _createMainImage($vehicleInfo) {
    $mainImageUrl = $vehicleInfo[7];
    $imageContent = "<div class='main-image-container' id='main-vehicle-image-container'>" .
    "<img class='main-image' src='" . $mainImageUrl .  "'>" .
    "</div>";

    return $imageContent;
  }

  private function _createAdditionalImages($vehicleInfo) {
    $mainImageUrl = $vehicleInfo[8];
    $imageArray = explode(';', $mainImageUrl);
    $imageContent = "<div class='additional-image-container'>" .
    "<ul>";

    $imageLimit = 0;
    foreach ($imageArray as $image) {
      if(++$imageLimit > 3) break;

      $additionalImage = "<li>" .
      "<img src='" . $image . "'>" .
      "</li>";

      $imageContent .= $additionalImage;
    }

    $imageContent .= "</ul> </div>";

    return $imageContent;
  }

  private function _createHead($vehicleInfo) {
    $head = "<!DOCTYPE html><html><head>" .
    "<title>" . $vehicleInfo[4] . " - " . $vehicleInfo[5] . " (" . $vehicleInfo[3] . ")</title>" .
    "<link rel='stylesheet' type='text/css' href='styles.css'>" .
    "</head>" .
    "<main class='content-container'>" .
    "<div class='vehicle-content-container'>";

    return $head;
  }

  private function _createFooter() {
    $footer = "</main> </div>" .
    "<script type='text/javascript' src='script.js'></script>";

    return $footer;
  }
}
?>
