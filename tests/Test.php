<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
    //========================================================Teste lister Partenaire==============================================================================//
   /*  public function testlistPartenTRUE()
    {
        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => "juniorlaye07",
                'PHP_AUTH_PW' => "junior07"
            ]
        );
        $crawler = $client->request('GET', '/api/super/listParten');
        $jsonstring = "[
                 {
                    \"id\":5,
                    \"ninea\":\"ANG2849\",
                    \"raisonSocial\":\"Merline SA\",
                    \"adresse\":\"Mermouz\",
                    \"email\":\"junis@gmail\",
                    \"telephone\":338251243,
                    \"status\":\"Actif\",
                } 
             ]";
        $rep = $client->getResponse();
        $this->assertSame(200, $client->getResponse()->getStatuscode());
    }  */
//============================Teste Creation de Comptbank===========================================================================================================================================//
   public function testaddTRUE()
    {

        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => "juniorlaye07",
                'PHP_AUTH_PW' => "junior07"
            ]
        );
        $crawler = $client->request(
            'POST',
            '/api/super/partenaire',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "ninea":"YFVJ6141",
                "raison_social":"Service SA",
                "tel":"338954625",
                "adresse":"Keur massar",
                "email":"serviceSa@gmail",
                "status":"Actif",
                "username":"alisson",
                "password":"alisson",
                "nom":"Fall",
                "prenom":"Sokhna",
                "tel":"777941094",
                "status":"Actif",
                "solde" :"0" ,
                "imageFile":"Api1.jpeg"              
            }'
        );
        $repo = $client->getResponse();
        var_dump($repo);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }  
//========================Test Depot Argent=======================£====================================================================// 
   /*   public function testFaireDepotTRUE()
    {

        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => "safia",
                'PHP_AUTH_PW' => "safia"
            ]
        );
        $crawler = $client->request(
            'POST',
            '/api/caisier/depotcompte',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "montant": "2500",
                "caisier": "10",
                "numeroCompte": "20190805142900"
                
  
            }'
        );
        $repo = $client->getResponse();
        var_dump($repo);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }  */
/*     public function testFaireDepotFALSE()
    {

        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => "safia",
                'PHP_AUTH_PW' => "safia"
            ]
        );
        $crawler = $client->request(
            'POST',
            '/api/caisier/depotcompte',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "montant":"",
                "caisier":"19",
                "numeroCompte":"20190806142743"
                
  
            }'
        );
        $repo = $client->getResponse();
        var_dump($repo);
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    } */
//==================================Test Créer un compte============================================================================================// 
/*    public function testnewTRUE()
    {

        $client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => "juniorlaye07",
                'PHP_AUTH_PW' => "junior07"
            ]
        );
        $crawler = $client->request(
            'POST',
            '/api/super/compte',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                
                "ninea":"ABD282539"                
            }'
        );
        $repo = $client->getResponse();
        var_dump($repo);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }  */

}
