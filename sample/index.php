<?php
require_once 'src/main/SampleSetup.php';
header('Access-Control-Allow-Origin: *');
use Bex\exceptions\BexException;
use Bex\merchant\request\InstallmentRequest;
use Bex\merchant\response\TicketRefresh;

$params = new SampleSetup($data=null,"checkout");
if(isset($params)){
    $success = $params->getSuccess();
    $ticketShortId = $params->getTicketId();
    $ticketPath = $params->getTicketPath();
    $ticketToken = $params->getTicketToken();
    $amount = $params->getAmount();
    $baseJsUrl = $params->getBaseJsUrl();
    $baseUrl = $params->getBaseUrl();
    $connectionId = $params->getConnectionId();
}
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

            if(isset($_REQUEST['ticketId'])){
                $resultData = $params->callResult($_GET['ticketId']);
                   if($resultData->getResult() == 'ok'){
                       $installmentCount = $resultData->getInstallmentCount();
                       $totalAmount = $resultData->getTotalAmount();
                       $cardData = $resultData->getCardFirst6()."******".$resultData->getCardLast4();
                       $bkmTokenId = $resultData->getBkmTokenId();
                       $posResult = $resultData->getPosResult();

                       $orderId = $posResult->getOrderId();
                       $authCode = $posResult->getAuthCode();
                       $posResponse = $posResult->getPosResponse();
                       $posResultCode = $posResult->getPosResultCode();
                       $referenceNumber = $posResult->getReferenceNumber();
                       $posTransactionId = $posResult->getPosTransactionId();
                       $posBank = $posResult->getPosBank();
                       exit(json_encode(array('installmentCount' => $installmentCount,'totalAmount' => $totalAmount , 'cardData' => $cardData , 'bkmTokenId' =>$bkmTokenId ,
                           'posResult' => array('orderId' => $orderId,'authCode' =>$authCode , 'posResponse' =>$posResponse , 'posResultCode' => $posResultCode ,
                               'referenceNumber' => $referenceNumber , 'posTransactionId' => $posTransactionId , 'posBank' =>$posBank) )));
                   }
               }

               if(isset($_REQUEST['reinit'])){
                 $ticketResponse = $params->callReInitTicket();
                   $ticketRefresh = new TicketRefresh($ticketResponse->getTicketShortId(),$ticketResponse->getTicketPath(),$ticketResponse->getTicketToken());
                   exit(json_encode(array("id"=>$ticketRefresh->getId(),"path" => $ticketRefresh->getPath(),"token" => $ticketRefresh->getToken()),JSON_PRETTY_PRINT));

               }

    }else{
        if(isset($_REQUEST['installment'])) {
            if($_REQUEST['installment'] == "checkout") {
                header('Content-type: application/json');
                $data =json_decode(file_get_contents('php://input'),TRUE);
                if(!empty($data)){

                    $installmentRequest = new InstallmentRequest($data["bin"],$data["totalAmount"],$data["ticketId"],$data["signature"]);
                    $binAndInstallments =  $params->getInstallmentResponse($installmentRequest);
                    if(isset($binAndInstallments)){
                        exit(json_encode(array("data" => $binAndInstallments, 'status' => 'ok' , 'error' => '')));
                    }else{
                        exit(json_encode(array("data" => null, 'status' => 'fail' , 'error' => 'Can not get installments')));

                    }
                }else{
                    throw  new BexException("Request body can not get !");
                }
            }


        }

    }

function stripslashes_deep($value)
{
    $value = is_array($value) ?
        array_map('stripslashes_deep', $value) :
        stripslashes($value);

    return $value;
}

?>
<!DOCTYPE HTML>
<html lang="tr" xmlns:th="http://www.thymeleaf.org">

<head>
    <!-- [if lt IE 9]>
    <script src="https://n11scdn.akamaized.net/static/new-design/static/js/third_party/html5.js"></script>
    <link rel="stylesheet" href="https://n11scdn.akamaized.net/static/new-design/static/style/css/ie.css?v=1"/>
    <![endif]-->

    <link href="src/main/css/merchant.css" rel="stylesheet" type="text/css"/>

    <title>Ödeme Onayı - n11.com</title>

    <link rel="alternate" media="only screen and (max-width: 767px)" href="https://m.n11.com/sepetim/odeme-onayi"/>


    <script src = "https://bex-js.finartz.com/v1/javascripts/bex.js" type="text/javascript"></script>

    <link rel="dns-prefetch" href="//cdn1.n11.com.tr"/>
    <link rel="dns-prefetch" href="//cdn2.n11.com.tr"/>
    <link rel="dns-prefetch" href="//cdn3.n11.com.tr"/>
    <link rel="dns-prefetch" href="//cdn4.n11.com.tr"/>
    <link rel="dns-prefetch" href="//metrics.n11.com/"/>
    <link rel="dns-prefetch" href="//googleads.g.doubleclick.net/"/>
    <link rel="dns-prefetch" href="//widget.criteo.com/"/>
    <link rel="dns-prefetch" href="//dis.eu.criteo.com/"/>
    <link rel="dns-prefetch" href="//www.googleadservices.com/"/>
    <link rel="dns-prefetch" href="//static.criteo.net/"/>
    <link rel="dns-prefetch" href="//mc.yandex.ru/"/>
    <link rel="dns-prefetch" href="//stats.g.doubleclick.net/"/>
    <link rel="dns-prefetch" href="//ajax.googleapis.com/"/>

    <meta charset="UTF-8"/>

    <link rel="shortcut icon" type="image/x-icon" href="https://n11scdn.akamaized.net/static/favicon.ico"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"/>

    <script type="text/javascript">
        /*<![CDATA[*/

        var _env = "prod";
        var mallFrontRoot = "//www.n11.com";
        var envSpecificMFRoot = "//www.n11.com";
        var mallFrontBaseRoot = "//www.n11.com";
        var staticRoot = "https://n11scdn.akamaized.net/static";
        var noImagePath = staticRoot + '/images/layout/no-image.jpg';

        var onProductImageError = function (img) {
            img.src = noImagePath;
        };

        /*]]>*/
    </script>

</head>
<body th:inline="text">
<div id="wrapper" class="simple checkout">


    <header id="header" class="simple">
        <div class="container">


            <a href="http://www.n11.com" class="logo" title="Alışverişin Uğurlu Adresi">
                <img
                    src="https://n11scdn.akamaized.net/a1/org/15/11/30/54/12/08/66/82/53/32/07/07/87650256438692757713.png"
                    width="124" height="46" alt="Alışverişin Uğurlu Adresi"/>
            </a>
            <span class="hLogoT">alışverişin uğurlu adresi</span>


            <div class="fTop">
                <ul>
                    <li><span class="icon iconOrj">ORİJİNAL ÜRÜNE <br/>%100 DESTEK</span></li>
                    <li><span class="icon iconSecurity">ÖDEME <br/>KORUMA SİSTEMİ</span></li>
                    <li><span class="icon iconCall">ÇAĞRI MERKEZİ <br/><span>0850 333 00 11</span></span></li>
                    <li><span class="icon iconPointer">İNTERNETTE <br/>GÜVENLİ ALIŞVERİŞ</span></li>
                </ul>
            </div>
        </div>
    </header>
    <div id="contentWrapper">
        <div class="container">

            <div class="checkoutWrapper">

                <div class="container">

                    <!-- Checkout Steps -->


                    <div id="paymentSteps" class="stepThree">
                        <ul>
                            <li class="stepOne" data-step="1">
                                <span></span><em>Sepetim</em><i></i>
                            </li>
                            <li class="stepTwo" data-step="2">
                                <span></span><em>Adres Seçimi</em><i></i>
                            </li>
                            <li class="stepThree active" data-step="3">
                                <span></span><em>İndirim &amp; Ödeme Onayı</em><i></i>
                            </li>
                        </ul>
                    </div>


                    <div id="newCheckoutForm">

                        <input type="hidden" id="orderNumber" name="orderNumber" value=""/>
                        <input type="hidden" id="installment" name="paymentModel.creditCardModel.installment"
                               value="1"/>
                        <input type="hidden" id="paymentType" name="paymentModel.paymentType" value="CREDITCARD"/>
                        <input type="hidden" id="creditCardRewardInfo" name="creditCardRewardInfo" value=""/>

                        <div class="checkoutContainer">


                            <div>

                                <div id="benefits" class="container">

                                    <input type="hidden" id="cartCoupon" name="cartCoupon" value=""/>

                                    <div id="benefitsWrapper" class="">

                                        <div id="benefitVoucherPoint" class="benefitsContainer">
                                            <h2>Yeni Kupon / Puan Ekle</h2>

                                            <div class="wrapper">
                                                <p>Kullanılabilir kupon / puanınızı eklemek için <span
                                                        id="showHiddenVoucher">tıklayınız.</span></p>

                                                <div class="hidden">
                                                    <div id="inputWrapper">
                                                        <label for="voucherPoint">
                                                            Kod Girişi
                                                        </label>
                                                        <input type="text" name="" id="voucherPoint" value=""/>
                                                        <span class="button medium red">
Ekle
                        </span>
                                                    </div>

                                                    <div class="message desc">
                                                        <span></span>
                                                        <p>
                                                            Kazandığınız kupon veya puan kodunu, bu kutucuğa girip Ekle
                                                            butonuna basarak indirimli alışveriş yapabilirsiniz.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div id="captcha"></div>
                                            </div>
                                        </div>


                                        <div class="benefitsContainer">
                                            <h2>
                                                Ürün Kuponları
                                            </h2>

                                            <div class="wrapper">


                                                <div class="benefits notapp disabled firstItem ">
                                                    <div class="container ">
                                                        <div class="discountArea ">
                                                            <p>%50</p>
                                                        </div>
                                                        <div class="benefitsDetail">
                                                            <h4>Fırsat11-%50 ürün indirim kuponu </h4>
                                                            <p>
                                                                Bitiş Tarihi: <strong>30.06.2016</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="notAvalCoupon icon">
                                                        <div>
                                                            <em class="icon-wrapper">
                                                                <span class="icon"></span>
                                                            </em>

                                                            <p>Bu kupon, sadece belirli bir Mağazanın belirli kategori
                                                                ürünleri için geçerlidir. Detayları, Hesabım &gt;
                                                                Kuponlarım sayfasından görebilirsiniz.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <br/>


                                    </div>

                                </div>

                                <input type="hidden" class="module" value="benefits"/>
                                <input type="hidden" id="showContract" value="false"/>


                                <div id="takeMsisdnPopup" class="popupWrapper newVoucherSuccessPopup">
                                    <div class="popupHeader">
                                        <h3 class="header">Kupon Girişi</h3>
                                        <span class="closePopup"></span>
                                    </div>

                                    <div class="popupContent">
                                        <div>
                                            <p>
                                                Turkcell Profesyoneller Kulübü kuponunuzun hesabınıza yüklenmesi için
                                                lütfen cep telefonu numaranızı girin.
                                            </p>

                                            <div class="formfield">
                                                <label for="msisdn">
                                                    Telefon numaranız :
                                                </label>
                                                <input type="text" name="msidsn" id="msisdn" maxlength="11"
                                                       data-validation="required"/>
                                            </div>

                                            <input type="hidden" id="couponCodeId" value=""/>

                                        </div>
                                    </div>

                                    <div class="popupFooter">
                                        <div class="buttons">
                                            <a id="sendMsisdnButton" class="button medium black">
                                                Tamam
                                            </a>
                                        </div>
                                    </div>

                                </div>


                                <div class="popupOverlay"></div>
                                <div class="popupWrapper" id="instantDiscountPopup">
                                    <div class="popupContent">
                                        <span class="closePopup closeBtn"></span>
                                        <div>
                                            Kuponu seçtiğiniz için Anında İndirim kampanyasından faydalanamıyorsunuz.
                                            Anında İndirim kampanyasından yararlanmak için kuponun yanında yer alan
                                            “Vazgeç” butonuna basınız.
                                            <br/>
                                            <div id="instantOkBtn" class="btn btnBlack">
                                                Tamam
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                /*<![CDATA[*/
                                window['paymentModel'] = {};
                                /*]]>*/
                            </script>


                            <div id="checkoutTabContainer">
                                <div class="header">
                                    <h2>
                                        Ödeme Seçenekleri
                                    </h2>
                                </div>
                                <div class="tabContainerWrapper">

                                    <div class="tabContainer">
                                        <div id="creditCardTab" class="tab">
                                            <h2>
                                                <a>Kredi Kartı ve Banka Kartı</a>
                                            </h2>
                                        </div>

                                        <div id="bkmExpressTab" class="tab active">
                                            <h2>
                                                <a>BKM Express</a>
                                            </h2>
                                        </div>

                                    </div>
                                    <div class="tabPanelContainer">

                                        <div id="bkmExpressTabPanel" class="tabPanel active">
                                            <div class="bkmNotice">

                                                <img class="logo" alt=""
                                                     src="https://www.n11.com/static/images/layout/bkmExpress2.jpg"/>
                                                <p>BKM Express ile ödeme yaparken <a
                                                        href="https://www.bkmexpress.com.tr" target="_blank">www.bkmexpress.com.tr</a>
                                                    sayfasına yönlendirileceksiniz. BKM Express sitesine üye olurken
                                                    kullandığınız kullanıcı adı ve şifreniz ile uygulamaya giriş
                                                    yapmanız gerekmektedir. Karşınıza gelen ödeme ekranından işlem
                                                    yapmak istediğiniz kartı ve ödeme şeklini seçerek kolayca ödeme
                                                    yapabilirsiniz. Alışverişinizi tamamladıktan sonra otomatik olarak
                                                    <a href="http://www.n11.com">www.n11.com</a> sitesine döneceksiniz.
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="warningMessage hidden">
                                <span></span>
                                <div>
                                    <p></p>
                                </div>
                            </div>


                            <div id="contractsContainer">
                                <div class="wrapper">
                                    <h4>CAYMA HAKKININ KULLANILMASI</h4>
                                    <p>
                                        Alıcı, hiçbir hukuki ve cezai sorumluluk üstlenmeksizin ve hiçbir gerekçe
                                        göstermeksizin, satın aldığı Mal/Hizmeti teslim tarihten itibaren 14 (ondört)
                                        gün içerisinde cayma hakkını kullanarak iade edebilir. Cayma hakkı bildirimi ve
                                        Sözleşmeye ilişkin sair bildirimler Satıcı’ya ait ve/veya Web sitesinde
                                        belirtilen iletişim kanalları ile gönderilecektir. Cayma hakkının kullanılması
                                        için süresi içerisinde Satıcı’ya mevzuat hükümlerine ve Websitesi’ndeki cayma
                                        hakkı kullanım seçeneğine uygun olarak bildirimde bulunulması şarttır.
                                    </p>
                                    <p>
                                        Cayma hakkı aşağıdaki hallerde kullanılamaz:
                                    </p>
                                    <ul>
                                        <li><b>a)</b> Fiyatı finansal piyasalardaki dalgalanmalara bağlı olarak değişen
                                            ve satıcının kontrolünde olmayan mal veya hizmetlere ilişkin sözleşmelerde
                                            (Ziynet, altın ve gümüş kategorisindeki ürünler)
                                        </li>
                                        <li><b>b)</b> Tüketicinin istekleri veya açıkça onun kişisel ihtiyaçları
                                            doğrultusunda hazırlanan, niteliği itibariyle geri gönderilmeye elverişli
                                            olmayan ve çabuk bozulma tehlikesi olan veya son kullanma tarihi geçme
                                            ihtimali olan malların teslimine ilişkin sözleşmelerde
                                        </li>
                                        <li><b>c)</b> Tesliminden sonra ambalaj, bant, mühür, paket gibi koruyucu
                                            unsurları açılmış olan mallardan; iadesi sağlık ve hijyen açısından uygun
                                            olmayanların teslimine ilişkin sözleşmelerde
                                        </li>
                                        <li><b>d)</b> Tesliminden sonra başka ürünlerle karışan ve doğası gereği
                                            ayrıştırılması mümkün olmayan mallara ilişkin sözleşmelerde
                                        </li>
                                        <li><b>e)</b> Tüketici tarafından ambalaj, bant, mühür, paket gibi koruyucu
                                            unsurları açılmış olması şartıyla maddi ortamda sunulan kitap, ses veya
                                            görüntü kayıtlarına, yazılım programlarına ve bilgisayar sarf malzemelerine
                                            ilişkin sözleşmelerde
                                        </li>
                                        <li><b>f)</b> Abonelik sözleşmesi kapsamında sağlananlar dışında gazete, dergi
                                            gibi süreli yayınların teslimine ilişkin sözleşmelerde
                                        </li>
                                        <li><b>g)</b> Belirli bir tarihte veya dönemde yapılması gereken, konaklama,
                                            eşya taşıma, araba kiralama, yiyecek-içecek tedariki ve eğlence veya
                                            dinlenme amacıyla yapılan boş zamanın değerlendirilmesine ilişkin
                                            sözleşmelerde
                                        </li>
                                        <li><b>h)</b> Bahis ve piyangoya ilişkin hizmetlerin ifasına ilişkin
                                            sözleşmelerde
                                        </li>
                                        <li><b>ı)</b> Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile
                                            ifasına başlanan hizmetlere ilişkin sözleşmelerde
                                        </li>
                                        <li><b>i)</b> Elektronik ortamda anında ifa edilen hizmetler ile tüketiciye
                                            anında teslim edilen gayri maddi mallara ilişkin sözleşmelerde ve sözleşmeye
                                            konu Mal/Hizmet’in Mesafeli Sözleşmeler Yönetmeliği’nin uygulama alanı
                                            dışında bırakılmış olan (satıcının düzenli teslimatları ile alıcının
                                            meskenine teslim edilen gıda maddelerinin, içeceklerin ya da diğer günlük
                                            tüketim maddeleri ile seyahat, konaklama, lokantacılık, eğlence sektörü gibi
                                            alanlarda hizmetler) Mal/Hizmet türlerinden müteşekkil olması halinde Alıcı
                                            ve Satıcı arasındaki hukuki ilişkiye Mesafeli Sözleşmeler Yönetmeliği
                                            hükümleri uygulanamaması sebebiyle cayma hakkı kullanılamayacaktır. Tatil
                                            kategorisinde satışa sunulan bu tür Mal/Hizmetlerin iptal ve iade şartları
                                            Satıcı uygulama ve kurallarına tabidir.
                                        </li>
                                    </ul>
                                    <div id="contactWrapper"></div>
                                </div>
                            </div>

                            <div id="contractField" class="">
                                <div class="box">
                                    <div class="formfield contract validation agreement ">
                                        <div>
                                            <label for="acceptAgreement">
                                                <input type="checkbox" name="acceptAgreement" id="acceptAgreement"
                                                       checked="checked"
                                                       data-validation="checked" data-val="true"/>
                                                <span class="type"
                                                      data-type="onbilgilendirme">Ön Bilgilendirme Formunu</span> ve
                                                <span class="type" data-type="mesafelisozlesme">Mesafeli Satış Sözleşmesini</span>
                                                okudum ve onaylıyorum.
                                            </label>
                                        </div>
                                        <div class="errorMessage" data-errormessagefor="acceptAgreement">
                                            <span class="top-arrow"></span>
                                            <div class="errorText"></div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div id="stickyCartTotal" style="text-align: center;">
                                <span id="paymentCanceled" style="color: #7A162E; font-size: 30px;  display: none;">
    Ödemeyi gerçekleştirmediniz....
                                </span>

                                <span id="paymentSuccess" style="color: #54900f; font-size: 30px;  display: none;">
    Ödemeniz başarıyla tamamlandı....
                                    <br/>Taksit Adedi       : <span id="bkmInstallmentCount"></span>
                                    <br/>Toplam Tutar       : <span id="bkmTotalAmount"></span>
                                    <br/>İşlem Yapılan Kart : <span id="bkmCard"></span>
                                    <br/>BkmTokenId          : <span id="bkmTokenId"></span>
                                    <br/>PosResult          : <span id="posResult"></span>
                                </span>

                                <div id="paymentField">

                                    <table id="summaryInfoTable">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span>Toplam Sipariş Tutarı</span>
                                                <strong>
                                                    110,64 TL
                                                </strong>
                                            </td>
                                            <td class="sep">
                                                <div></div>
                                            </td>
                                            <td class="discountTotal">
                                                <span>İndirim<br/> Tutarı</span>
                                                <strong>
                                                    -10,09 TL
                                                </strong>
                                            </td>
                                            <td class="sep">
                                                <div></div>
                                            </td>
                                            <td class="rewardPoint">
                                                <span>Kredi Kartı Puanı</span>
                                                <strong>
                                                    0,00 TL
                                                </strong>
                                            </td>
                                            <td class="sep">
                                                <div></div>
                                            </td>
                                            <td class="interestCost">
                                                <span>Vade<br/> Farkı</span>
                                                <strong>
                                                    0,00 TL
                                                </strong>
                                            </td>
                                            <td class="sep">
                                                <div></div>
                                            </td>
                                            <td class="totalCost">
                                                <span>Ödenecek<br/> Tutar</span>
                                                <strong id="finalAmount">
                                                    100,55 TL
                                                </strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div id="payment-dropin" style="top: 20px; right: 10px; position: absolute;">

                                    </div>

                                   <div>



                                    </div>

                                    <!--<div th:if="${!success}">
                                        [[${errorMessage}]]
                                    </div>-->

                                </div>
                            </div>
                        </div>

                        <div id="checkoutContainerRight">
                            <div class="stickyWrapper" style="top: 0px;">


                                <div id="myCartContainer">
                                    <h3>Siparişlerim</h3>


                                    <div class="catalogItem">
                                        <div class="imgWrapper">
        <span>

            <img src="https://n11scdn.akamaized.net/a1/80/16/06/01/60/76/33/09/22/20/65/06/40/14508547081542287044.jpg"
                 alt="ARNİCA BORA 5000 SU FİLTRELİ ELEKTRİKLİ SÜPÜRGE" onerror="onProductImageError(this);"/>
                </span>
                                        </div>
                                        <div class="productInfo">
                                            <p>
                                                ARNİCA BORA 5000 ...
                                            </p>
                                            <span class="price">100,55 TL</span>

                                        </div>
                                    </div>
                                </div>


                                <div id="addressSummary">
                                    <h3>Teslimat Adresi</h3>
                                    <div>

                                        <h4>bkm,</h4>
                                        <p>
                                            Nispetiye cad. Akmerkez E3 Blok Kat: 3 Etiler 34337 Beşiktaş İstanbul<br/>
                                            (536) 877 99 51 </p>
                                    </div>

                                    <h3>Fatura Adresi</h3>
                                    <div>

                                        <h4>bkm,</h4>
                                        <p>
                                            Nispetiye cad. Akmerkez E3 Blok Kat: 3 Etiler 34337 Beşiktaş İstanbul<br/>
                                            (536) 877 99 51 </p>

                                        <a href="https://www.n11.com/sepetim/adres-secimi">
                                            Adresi değiştir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="popupWrapper" id="installmentPopup" style="width: 980px;">
                <div class="popupHeader">
                    <span class="closePopup"></span>
                </div>
                <div class="popupContent" id="paymentInstallmentTableContainer">


                    <div class="panelContent">


                        <table id="installmentTable" class="payOptTable">
                            <tbody>
                            <tr>
                                <th>Taksit</th>

                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/61/20/46/50/46/53/11/21/48/21856008756702497004.png"
                                        alt="Akbank"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/91/25/02/23/30/70/53/86/33/41723796493338300283.png"
                                        alt="Garanti Bankası"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/61/67/41/41/96/49/41/11/64/42966158248484555107.png"
                                        alt="Finansbank"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/47/24/25/84/60/18/94/34/93/72752917682784548390.png"
                                        alt="Türkiye İş Bankası"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/72/65/85/29/86/57/86/09/27/2639257549785878355.png"
                                        alt="Türkiye Halk Bankası"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/85/19/26/90/80/01/63/92/57/6235882994802343121.png"
                                        alt="Yapı Kredi"/>
                                </th>
                                <th class="bank">
                                    <img
                                        src="https://n11scdn.akamaized.net/a1/org/16/01/14/65/90/42/31/90/16/47/34/25/75263483937949268257.png"
                                        alt="Bank Asya"/>
                                </th>
                            </tr>

                            <tr class="payDetail">
                                <td class="installment">
                                    3
                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>103,30 TL</div>
                                    <span>309,90 TL</span>

                                </td>
                            </tr>
                            <tr class="payDetail">
                                <td class="installment">
                                    6
                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>51,65 TL</div>
                                    <span>309,90 TL</span>

                                </td>
                            </tr>
                            <tr class="payDetail">
                                <td class="installment">
                                    9
                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td>
                                    <div>35,48 TL</div>
                                    <span>319,32 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>


                                <td class="cashPrice">
                                    <div>34,43 TL</div>
                                    <span>309,90 TL</span>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="paymentDetailFooter">Ödeme seçenekleri hakkında detaylı bilgi için<a
                                href="http://www.n11.com/genel/odeme-secenekleri-393251" target="_blank" rel="nofollow">
                                tıklayın</a></div>


                        <div class="tableNot one">

                            <div><span class="clrBox"></span>Peşin fiyatına taksit seçeneği</div>


                        </div>


                    </div>

                </div>
                <br/>
            </div>
            <input type="hidden" class="module" value="checkout"/>

            <script type="text/javascript">
                /*<![CDATA[*/
                var isOrderCreated = false;
                var isValidationFailed = false;
                /*]]>*/
            </script>

            <script type="text/javascript">
                if (typeof dataLayer === 'undefined')
                    dataLayer = [];
                try {
                } catch (e) {
                }
            </script>

            <input type="hidden" id="hasNoCoupons" value="false"/>
            <input type="hidden" id="isGuestBuyer" value="false"/>

        </div>
    </div>


    <footer id="footer" class="simple">
        <div class="container">
            <div class="fBottom">
                <div class="legalRules">

                    <span class="copyright">© Telif Hakkı 2012-2016 n11.com</span>
                </div>

                <span class="iconLogo iconLogoPaypal fRight"></span>
                <span class="iconLogo iconLogoBKM fRight"></span>
                <span class="iconLogo iconLogoAmex fRight"></span>
                <span class="iconLogo iconLogoVisa fRight"></span>
                <span class="iconLogo iconLogoMaster fRight"></span>
            </div>
        </div>
    </footer>

    <div class="hidden">


        <style>
            [id=contentSellerList] .top {
                display: inline-block;
                width: 100%
            }

            .slider .kkcountdown-box .kkc-godz-text,
            .slider .kkcountdown-box .kkc-min-text,
            .slider .kkcountdown-box .kkc-sec-text {
                color: #000;
            }

            #headerCampaign {
                background: #000 url('https://n11scdn.akamaized.net/a1/org/16/06/01/82/13/75/55/07/66/21/90/13/51386062264171319200.jpg') no-repeat bottom center;
                display: block;
                height: 60px;
                top: 0;
                width: 100%;
            }

            .slider .countdownEl {
                height: 130px;
                margin-left: -118px;
                top: 174px;
                width: 240px;
                padding-top: 11px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }

            .slider .kkcountdown-box {
                position: static;
            }

            .slider .kkcountdown-box .kkc-godz,
            .slider .kkcountdown-box .kkc-min,
            .slider .kkcountdown-box .kkc-sec {
                background: url('https://n11scdn.akamaized.net/a1/org/16/03/11/91/08/79/85/96/90/59/71/31/41575723023654209106.png') no-repeat;
                color: #fff;
                font-size: 44px;
                font-weight: bold;
                height: 98px;
                width: 66px;
            }

            .slider .kkcountdown-box .kkc-godz:after,
            .slider .kkcountdown-box .kkc-min:after,
            .slider .kkcountdown-box .kkc-sec:after {
                content: "";
                background: #050505;
                position: absolute;
                height: 1px;
                width: 65px;
                top: 48px;
                z-index: 99;
                opacity: .4;
                left: 0;
            }

            .slider .kkcountdown-box .kkc-min {
                left: 88px;
            }

            .slider .kkcountdown-box .kkc-sec {
                left: 163px;
            }

            .slider .kkcountdown-box .kkc-godz-text,
            .slider .kkcountdown-box .kkc-min-text,
            .slider .kkcountdown-box .kkc-sec-text {
                color: #000;
                top: 113px;
            }

            .slider .kkcountdown-box .kkc-godz {
                left: 12px;
            }

            .slider .kkcountdown-box .kkc-godz-text {
                left: 30px;
            }

            .slider .kkcountdown-box .kkc-min-text {
                left: 97px;
            }

            .slider .kkcountdown-box .kkc-sec-text {
                left: 172px;
            }

            @-moz-document url-prefix() {
                .slider .kkcountdown-box {
                    top: 24px !important;
                }
            }

            #wrapper.travelCategory .tab.flights {
                display: none
            }
        </style>


    </div>
</div>
<div class="popupOverlay"></div>


<script type="text/javascript">
    /*<![CDATA[*/
    var recommendationEnabled = true;
    var userAuthenticated = true;
    var isDevMode = false;
    var getLabel = function (key) {
        return dmallLabels[key] || '';
    };
    /*]]>*/
</script>

<script type="text/javascript">

    var ticketIdForInit = <?php echo "'".$ticketShortId."'" ;?>;
    var ticketPathForInit = <?php echo "'".$ticketPath."'" ;?>;
    var ticketTokenForInit = <?php echo "'".$ticketToken."'" ;?>;
        Bex.init({"id":ticketIdForInit,"path":ticketPathForInit,"token":ticketTokenForInit}, "modal", {
            container: "payment-dropin",
            buttonSize: [135, 70],

            onCancel: function () {
                $.ajax({
                    type: "GET",
                    url: "index.php?reinit=true",
                    timeout: 100000,
                    success: function (data) {
                        if(typeof data !='undefined') {
                            var ticketObj = [];
                            ticketObj["id"] = JSON.parse(data).id;
                            ticketObj["path"] = JSON.parse(data).path;
                            ticketObj["token"] = JSON.parse(data).token;
                            Bex.refresh(ticketObj);
                        }
                    }
                });
                console.info("User canceled the payment");
            },
            onComplete: function (status) {

                $.ajax({
                    type: 'post',
                    url: "index.php?ticketId=" + ticketPathForInit,
                    contentType: "application/json",
                    success: function (data) {
                        if (typeof data != 'undefined') {
                            $('#bkmInstallmentCount').text(JSON.parse(data).installmentCount);
                            $('#bkmTotalAmount').text(JSON.parse(data).totalAmount);
                            $('#bkmCard').text(JSON.parse(data).cardData);
                            $('#bkmTokenId').text(JSON.parse(data).bkmTokenId);
                            $('#posResult').text(JSON.stringify(JSON.parse(data).posResult));
                            $('#paymentSuccess').show();
                            $('#paymentField').hide();
                        }

                    }
                });

                console.info("Payment completed with status: " + status);
            }
        });


    /*]]>*/
</script>

<input type="hidden" id="hasNotification" value="false"/>
<input type="hidden" class="module" value="flashNotification"/>

<div id="loadingBar"></div>

</body>
</html>
