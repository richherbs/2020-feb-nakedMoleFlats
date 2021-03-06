<?php

require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use NMF\DisplayDwellings;
use NMF\Dwelling;

$_GET['dwellingId'] = 1;

class FunctionTest extends TestCase {

    //success test
    public function testSuccessDisplayDwellings()
    {
        $fakeDwelling = $this->createMock(Dwelling::class);
        $fakeDwelling
        ->method('getDwellingId')
        ->willReturn('1');
        $fakeDwelling
        ->method('getAgentRef')
        ->willReturn('Alex M');
        $fakeDwelling-> expects($this->once())
        ->method('getAddress1')
        ->willReturn('Mayden Academy');
        $fakeDwelling
        ->method('getAddress2')
        ->willReturn('1 Widcombe Crescent');
        $fakeDwelling
        ->method('getTown')
        ->willReturn('Bath');
        $fakeDwelling
        ->method('getPostcode')
        ->willReturn('BA2 6AH');
        $fakeDwelling
        ->method('getDescription')
        ->willReturn('This is a house');
        $fakeDwelling
        ->method('getBedrooms')
        ->willReturn(5);
        $fakeDwelling
        ->method('getPrice')
        ->willReturn(3000000);
        $fakeDwelling
        ->method('getImage')
        ->willReturn('testpic.jpeg');
        $fakeDwelling
        ->method('getType')
        ->willReturn('Sale');
        $fakeDwelling
        ->method('getStatus')
        ->willReturn('Sold');

        //expected result
        $expected = 
        '<div class="dwellingContainer">'    
             . '<div class="dwellingImageContainer">'
                     . '<img class="dwellingMainImage" src="https://dev.maydenacademy.co.uk/resources/property-feed/images/testpic.jpeg" alt="Picture of Property">'
                     . '<div class="imageStatusText">Sold</div>'
             . '</div>'
             . '<div class="dwellingInfo">'
                 . '<div class="price">£3000000</div>'
                 . '<hr>'
                 . '<div class="dwellingAddress info">Mayden Academy, 1 Widcombe Crescent, Bath</div>'
                 . '<div class="dwellingPostcode info">BA2 6AH</div>'
                 . '<div class="dwellingStatus info">Sold</div>'
                 . '<div class="dwellingBedrooms info"><i class="fas fa-bed"></i> 5 bedrooms</div>'
             . '</div>'
             . '<form method="GET" action="propertydetails.php">'
         . '<button name="dwellingId" type="submit" value=1>View Property</button>'
         . '</form>'
         . '</div>';
        
        //run test
        $testDwellings = [$fakeDwelling];

        $result = DisplayDwellings::displayAllDwellings($testDwellings);
        $this->assertEquals($expected, $result);
    }
    // test to check function behaves correctly if certain resources are unavailable in the DB.
    // tests that the placeholder image is shown correctly, and that the callout with the property
    // status does not show if the property is still for sale
    public function testResourcesNotFoundTest()
    {
        $fakeDwelling = $this->createMock(Dwelling::class);
        $fakeDwelling
        ->method('getDwellingId')
        ->willReturn('1');
        $fakeDwelling
        ->method('getAgentRef')
        ->willReturn('Alex M');
        $fakeDwelling-> expects($this->once())
        ->method('getAddress1')
        ->willReturn('Mayden Academy');
        $fakeDwelling
        ->method('getAddress2')
        ->willReturn('1 Widcombe Crescent');
        $fakeDwelling
        ->method('getTown')
        ->willReturn('Bath');
        $fakeDwelling
        ->method('getPostcode')
        ->willReturn('BA2 6AH');
        $fakeDwelling
        ->method('getDescription')
        ->willReturn('This is a house');
        $fakeDwelling
        ->method('getBedrooms')
        ->willReturn(5);
        $fakeDwelling
        ->method('getPrice')
        ->willReturn(3000000);
        $fakeDwelling
        ->method('getImage')
        ->willReturn('');
        $fakeDwelling
        ->method('getType')
        ->willReturn('Sale');
        $fakeDwelling
        ->method('getStatus')
        ->willReturn('For Sale');

        //expected result
        $expected = 
        '<div class="dwellingContainer">'    
             . '<div class="dwellingImageContainer">'
                     . '<img class="dwellingMainImage" src="src/images/testpic.jpeg" alt="Picture of Property">'
             . '</div>'
             . '<div class="dwellingInfo">'
                 . '<div class="price">£3000000</div>'
                 . '<hr>'
                 . '<div class="dwellingAddress info">Mayden Academy, 1 Widcombe Crescent, Bath</div>'
                 . '<div class="dwellingPostcode info">BA2 6AH</div>'
                 . '<div class="dwellingStatus info">For Sale</div>'
                 . '<div class="dwellingBedrooms info"><i class="fas fa-bed"></i> 5 bedrooms</div>'
             . '</div>'
         . '<form method="GET" action="propertydetails.php">'
         . '<button name="dwellingId" type="submit" value=1>View Property</button>'
         . '</form>'
         . '</div>';
        
        //run test
        $testDwellings = [$fakeDwelling];

        $result = DisplayDwellings::displayAllDwellings($testDwellings);
        $this->assertEquals($expected, $result);
    }
    public function testFailureDisplayDwellings()
    {
        //expected result
        $expected = 
        '<div class="dwellingInfo">'
            . '<div class="noDwellingsFound">'
                . 'Uh-Oh! It looks like something\'s gone wrong on our end. We\'ll have this fixed as soon as possible. Please try again later.'
            . '</div>'
        . '</div>';
        //run test
        $result = DisplayDwellings::displayAllDwellings([]);
        $this->assertEquals($expected, $result);
    }
    //malformed code test
    public function testMalformedCodeDisplayDwellings()
    {
        //expect error
        $this->expectException(TypeError::class);
        //run test
        $result = DisplayDwellings::displayAllDwellings('Mayden Academy');
    }

    //success test
    public function testSuccessDisplayDwelling()
    {
        $fakeDwelling = $this->createMock(Dwelling::class);
        $fakeDwelling
        ->method('getDwellingId')
        ->willReturn('1');
        $fakeDwelling
        ->method('getAgentRef')
        ->willReturn('Alex M');
        $fakeDwelling-> expects($this->once())
        ->method('getAddress1')
        ->willReturn('Mayden Academy');
        $fakeDwelling
        ->method('getAddress2')
        ->willReturn('1 Widcombe Crescent');
        $fakeDwelling
        ->method('getTown')
        ->willReturn('Bath');
        $fakeDwelling
        ->method('getPostcode')
        ->willReturn('BA2 6AH');
        $fakeDwelling
        ->method('getDescription')
        ->willReturn('Description');
        $fakeDwelling
        ->method('getBedrooms')
        ->willReturn(5);
        $fakeDwelling
        ->method('getPrice')
        ->willReturn(3000000);
        $fakeDwelling
        ->method('getImage')
        ->willReturn('testpic.jpeg');
        $fakeDwelling
        ->method('getType')
        ->willReturn('Sale');
        $fakeDwelling
        ->method('getStatus')
        ->willReturn('For Sale');

        //expected result
        $expected = 
        '<main class="propertyDetailsContainer">'
        .'<img class="propertyDetailsImage mobileImage" src="https://dev.maydenacademy.co.uk/resources/property-feed/images/testpic.jpeg">'
        .'<div class="propertyDetailsText">'
        .'<div class="price">£3000000</div>'
        .'<hr>'
        .'<div class="dwellingAddress info">Mayden Academy, 1 Widcombe Crescent, Bath</div>'
        .'<div class="dwellingPostcode info">BA2 6AH</div>'
        .'<div class="dwellingStatus info">For Sale</div>'
        .'<div class="dwellingBedrooms info"><i class="fas fa-bed"></i> 5 Bedrooms</div>'
        .'<hr>'
        .'<img class="propertyDetailsImage desktopImage" src="https://dev.maydenacademy.co.uk/resources/property-feed/images/testpic.jpeg">'
        .'<div class="descriptionHeader info">Description:</div>'
        .'<div class="dwellingDescription info">Description</div>'
        .'</div>'
        .'</main>;';

        $result = DisplayDwellings::displayDwelling($fakeDwelling);
        $this->assertEquals($expected, $result);
    }
    // test to check function behaves correctly if certain resources are unavailable in the DB.
    // tests that the placeholder image is shown correctly, and that the callout with the property
    // status does not show if the property is still for sale
    public function testDisplayDwellingNoResource()
    {
        $fakeDwelling = $this->createMock(Dwelling::class);
        $fakeDwelling
        ->method('getDwellingId')
        ->willReturn('1');
        $fakeDwelling
        ->method('getAgentRef')
        ->willReturn('Alex M');
        $fakeDwelling-> expects($this->once())
        ->method('getAddress1')
        ->willReturn('Mayden Academy');
        $fakeDwelling
        ->method('getAddress2')
        ->willReturn('1 Widcombe Crescent');
        $fakeDwelling
        ->method('getTown')
        ->willReturn('Bath');
        $fakeDwelling
        ->method('getPostcode')
        ->willReturn('BA2 6AH');
        $fakeDwelling
        ->method('getDescription')
        ->willReturn('Description');
        $fakeDwelling
        ->method('getBedrooms')
        ->willReturn(5);
        $fakeDwelling
        ->method('getPrice')
        ->willReturn(3000000);
        $fakeDwelling
        ->method('getImage')
        ->willReturn('');
        $fakeDwelling
        ->method('getType')
        ->willReturn('Sale');
        $fakeDwelling
        ->method('getStatus')
        ->willReturn('For Sale');

        //expected result
        $expected = 
        '<main class="propertyDetailsContainer">'
        .'<img class="propertyDetailsImage mobileImage" src="src/images/testpic.jpeg">'
        .'<div class="propertyDetailsText">'
        .'<div class="price">£3000000</div>'
        .'<hr>'
        .'<div class="dwellingAddress info">Mayden Academy, 1 Widcombe Crescent, Bath</div>'
        .'<div class="dwellingPostcode info">BA2 6AH</div>'
        .'<div class="dwellingStatus info">For Sale</div>'
        .'<div class="dwellingBedrooms info"><i class="fas fa-bed"></i> 5 Bedrooms</div>'
        .'<hr>'
        .'<img class="propertyDetailsImage desktopImage" src="src/images/testpic.jpeg">'
        .'<div class="descriptionHeader info">Description:</div>'
        .'<div class="dwellingDescription info">Description</div>'
        .'</div>'
        .'</main>;';

        $result = DisplayDwellings::displayDwelling($fakeDwelling);
        $this->assertEquals($expected, $result);
    }
    public function testFailureDisplayDwelling()
    {
        $fakeDwelling = $this->createMock(Dwelling::class);
        unset($_GET['dwellingId']);
        //expected result
        $expected = 
        '<div class="dwellingInfo">'
            . '<div class="noDwellingsFound">'
                . 'Uh-Oh! It looks like something\'s gone wrong on our end. We\'ll have this fixed as soon as possible. Please try again later.'
            . '</div>'
        . '</div>';
        //run test
        
        $result = DisplayDwellings::displayDwelling($fakeDwelling);
        $this->assertEquals($expected, $result);
    }
    //malformed code test
    public function testMalformedCodeDisplayDwelling()
    {
        //expect error
        $this->expectException(TypeError::class);
        //run test
        $result = DisplayDwellings::displayAllDwellings('Mayden Academy');
    }

    
}