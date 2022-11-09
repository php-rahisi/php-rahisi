<?php
namespace support\lib;

class dictionaly {
    public function english_swahili(){
        return [
            'products'=>'bidhaa',
            'product'=>'bidhaa',
            'selling'=>'kuuza',
            'stores'=>'maduka',
            'users'=>'watumiaji',
            'sales'=>'mauzo',
            'action'=>'hatua',
            'product name'=>'bidhaa',
            'product unit'=>'kipimo cha bidhaa',
            'price per unit'=>'bei@',
            'total price'=>'jumla',
            'total sales'=>'jumla',
            'total carts'=>'jumla',
            'total'=>'jumla',
            'search by sells date'=>'chagua tarehe',
            'account'=>'taarifa zangu',
            'sales report'=>'taarifa za mauzo',
            'closed sales reports' => 'taarifa za mauzo yaliyofungwa',
            'close sales' => 'funga mauzo ya leo',
            'name'=>'jina',
            'quantity'=>'kiasi',
            'price'=>'gharama',
            'time'=>'muda',
            'carts'=>'begi la manunuzi',
            'sells report'=>'Ripoti ya mauzo',
            'workers'=>'Wafanyakazi',
            'add new'=>'ongeza',
            'each products total sale'=>'Mauzo kwa kila bidhaa',
            'total sales per day'=>'mauzo ya kilasiku',
            'selling page'=>'kurasa ya kuuzia',
            'sale now'=>'uza',
            'sale carts'=>'uza vyote',
            'view carts'=>'angalia begi',
            'view sales'=>'angalia mauzo',
            'add to cart'=>'weka kwenye begi',            
            'weight'=>'subili',
            'available'=>'zilizopo',         
            'unit'=>'kipimo cha kuuzia',         
        ];
    }
}


$lang = new dictionaly();

if(isset($_COOKIE['language'])){
    $language = $lang->english_swahili();
    define('DICTIONALY',$language);
}