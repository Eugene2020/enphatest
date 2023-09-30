<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");

$nav = new \Bitrix\Main\UI\PageNavigation("nav-more-news");
$nav->allowAllRecords(true)
   ->setPageSize(10)
   ->initFromUri(); // Инициализация постраничной навигации

$filter = [
    'ACTIVE'    => 'Y',
    'IBLOCK_ID' => '6',
];

$elements = \Bitrix\Iblock\Elements\ElementResidentsTable::getList([
    'select'      => [
        'ID', 
        'FIO', 
        'HOME.ELEMENT.NUMBER',
        'HOME.ELEMENT.STREET',
        'HOME.ELEMENT.CITY',
    ],
    'filter'      => $filter,
    "count_total" => true,
    "offset"      => $nav->getOffset(),
    "limit"       => $nav->getLimit(),
])->fetchCollection(); // Получили элементы

$elementsCount = \Bitrix\Iblock\Elements\ElementResidentsTable::getCount($filter); // Количество элементов

$nav->setRecordCount($elementsCount);

foreach ($elements as $element) {

    $residentFio        = $element->getFio()->getValue();
    $residentHomeNubmer = $element->getHome()->getElement()->getNumber()->getValue();
    $residentStreet     = $element->getHome()->getElement()->getStreet()->getValue();
    $residentCity       = $element->getHome()->getElement()->getCity()->getValue();

    echo $residentFio.' - '.$residentCity.', '.$residentStreet.', '.$residentHomeNubmer.'<br>';

} // Вывод элементов

$APPLICATION->IncludeComponent(
   "bitrix:main.pagenavigation",
   "",
   array(
      "NAV_OBJECT" => $nav,
      "SEF_MODE"   => "Y",
   ),
   false
); // Компонент постраничной навигации
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
