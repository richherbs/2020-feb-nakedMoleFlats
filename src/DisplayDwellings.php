<?php

namespace NMF;

class DisplayDwellings
{
    /**
     * Function to output the HTML for displaying all the dwelling cards on the frontend
     * 
     * @param Array $dwellingsToDisplay An indexed array containing dwelling objects, populated from the DB
     * 
     * @return string the HTML for displaying the dwellings on the front end
     */
    public static function displayAllDwellings(array $dwellingsToDisplay): string
    {
        // Check that the database has some dwellings in it
        if (!count($dwellingsToDisplay)) {
            // If the DB is empty (probably because a refresh failed), return a neat error to the front end
            return
                '<div class="dwellingInfo">'
                . '<div class="noDwellingsFound">'
                . 'Uh-Oh! It looks like something\'s gone wrong on our end. We\'ll have this fixed as soon as possible. Please try again later.'
                . '</div>'
                . '</div>';
        }

        // Empty string to which our HTML will be appended
        $result = '';

        foreach ($dwellingsToDisplay as $dwelling) {
            $statusBox = '';
            //check if a dwelling is sold or let agreed and display overlay if so
            if ($dwelling->getStatus() === 'Sold' || $dwelling->getStatus() === 'Let Agreed') {
                $statusBox = "<div class=\"imageStatusText\">" . $dwelling->getStatus() . "</div>";
            }
            // Check that the database has a provided image URL for the dwelling in question, and use
            // A placeholder image if it does not
            if (!$dwelling->getImage()) {
                $image = 'src/images/testpic.jpeg';
            } else {
                $image = 'https://dev.maydenacademy.co.uk/resources/property-feed/images/' . $dwelling->getImage();
            }
            // Generate the actual HTML to display the dwelling's information
            $result .= '<div class="dwellingContainer">'
                . '<div class="dwellingImageContainer">'
                . '<img class="dwellingMainImage" src="' . $image . '" alt="Picture of Property">'
                . $statusBox
                . '</div>'
                . '<div class="dwellingInfo">'
                . '<div class="price">£' . $dwelling->getPrice() . '</div>'
                . '<hr>'
                . '<div class="dwellingAddress info">' . $dwelling->getAddress1() . ', ' . $dwelling->getAddress2() . ', ' . $dwelling->getTown() . '</div>'
                . '<div class="dwellingPostcode info">' . $dwelling->getPostcode() . '</div>'
                . '<div class="dwellingStatus info">' . $dwelling->getStatus() . '</div>'
                . '<div class="dwellingBedrooms info"><i class="fas fa-bed"></i>' . ' ' . $dwelling->getBedrooms() . ' bedrooms</div>'
                . '</div>'
                . '<form method="GET" action="propertydetails.php">'
                . '<button name="dwellingId" type="submit" value='.$dwelling->getDwellingId().'>View Property</button>'
                . '</form>'
                . '</div>';
        }

        return $result;
    }
    /**
     * Function to display property details for a single dwelling
     * 
     * @param (bool or Dwelling) $dwellingToDisplay the dwelling to be displayed, or false if PDO encountered a problem
     * 
     * @return string values to be displayed on the frontend
     */
    public static function displayDwelling($dwellingToDisplay): string
    {
        // Check that the database has some dwellings in it
        if (!isset($_GET['dwellingId'])) {
            // If the DB is empty (probably because a refresh failed), return a neat error to the front end
            return
                '<div class="dwellingInfo">'
                . '<div class="noDwellingsFound">'
                . 'Uh-Oh! It looks like something\'s gone wrong on our end. We\'ll have this fixed as soon as possible. Please try again later.'
                . '</div>'
                . '</div>';
        }
        
        // Check that the database has a provided image URL for the dwelling in question, and use
        // A placeholder image if it does not
        if (!$dwellingToDisplay->getImage()) {
            $image = 'src/images/testpic.jpeg';
        } else {
            $image = 'https://dev.maydenacademy.co.uk/resources/property-feed/images/' . $dwellingToDisplay->getImage();
        }
        // Generate the actual HTML to display the dwelling's information
        $result = '<main class="propertyDetailsContainer">'
        .'<img class="propertyDetailsImage mobileImage" src="'.$image.'">'
        .'<div class="propertyDetailsText">'
        .'<div class="price">£' . $dwellingToDisplay->getPrice() . '</div>'
        .'<hr>'
        .'<div class="dwellingAddress info">' . $dwellingToDisplay->getAddress1() . ', ' . $dwellingToDisplay->getAddress2() . ', ' . $dwellingToDisplay->getTown() . '</div>'
        .'<div class="dwellingPostcode info">' . $dwellingToDisplay->getPostcode() . '</div>'
        .'<div class="dwellingStatus info">' . $dwellingToDisplay->getStatus() . '</div>'
        .'<div class="dwellingBedrooms info"><i class="fas fa-bed"></i>' . ' ' . $dwellingToDisplay->getBedrooms() . ' Bedrooms</div>'
        .'<hr>'
        .'<img class="propertyDetailsImage desktopImage" src="'.$image.'">'
        .'<div class="descriptionHeader info">Description:</div>'
        .'<div class="dwellingDescription info">'.$dwellingToDisplay->getDescription().'</div>'
        .'</div>'
        .'</main>;';

        return $result;
    }
}
