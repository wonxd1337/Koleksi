<?php

function feedback404()
{
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
}

if (isset($_GET['mxwn'])) {
    $filename = "goban.txt";
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $target_string = strtolower($_GET['mxwn']);
    foreach ($lines as $item) {
        if (strtolower($item) === $target_string) {
            $BRAND = strtoupper($target_string);
            $SMALLBRAND = $target_string;
        }
    }
    if (isset($BRAND)) {
        $BRANDS = $BRAND;
        $SMALLBRANDS = $SMALLBRAND;
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $fullUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (isset($fullUrl)) {
            $parsedUrl = parse_url($fullUrl);
            $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : '';
            $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
            $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
            $query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';
            $baseUrl = $scheme . "://" . $host . $path . '?' . $query;
            $urlPath = $baseUrl;
        } else {
            echo "URL saat ini tidak didefinisikan.";
        }
    } else {
        feedback404();
        exit();
    }
} else {
    feedback404();
    exit();
}

/*

*GANTI NAMA BRAND DENGAN INI
<?php echo $BRANDS ?>

* GANTI URL PATH DENGAN INI
<?php echo $urlPath ?>

<?php echo $SMALLBRAND ?>

* SAMA GANTI REDIRECT LOGIN/REGISTER

*/

?>


<!-- Script Landing Page -->
<!DOCTYPE HTML>
<html xmlns:wormhole="http://www.w3.org/1999/xhtml" lang="id-ID">
<head>
<meta charset="utf-8" />
<title><?php echo $BRANDS ?> SITUS RESMI TERPERCAYA - MA Plus Al Hadi Padangan</title>
<meta name="description" content="<?php echo $BRANDS ?> MA Plus AL Hadi, Madrasah Aliyah yang mengitegrasikan dan mengkombinasikan Science dan Agama, mencetak generasi ilmiah yang berakhlakul karimah dan berprestasi pada tingkat internasional." />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta name="aplus-auto-exp" content="[{&quot;filter&quot;:&quot;exp-tracking=suggest-official-store&quot;,&quot;logkey&quot;:&quot;/lzdse.result.os_impr&quot;,&quot;props&quot;:[&quot;href&quot;],&quot;tag&quot;:&quot;a&quot;}]" />
<meta name="data-spm" content="a2o4j" />
<meta name="robots" content="index, follow" />
<meta name="og:url" content="<?php echo $urlPath ?>" />
<meta name="og:title" content="<?php echo $BRANDS ?> SITUS RESMI TERPERCAYA - MA Plus Al Hadi Padangan" />
<meta name="og:type" content="product" />
<meta name="og:description" content="<?php echo $BRANDS ?> MA Plus AL Hadi, Madrasah Aliyah yang mengitegrasikan dan mengkombinasikan Science dan Agama, mencetak generasi ilmiah yang berakhlakul karimah dan berprestasi pada tingkat internasional." />
<meta name="og:image" content="https://i.postimg.cc/HW9B4qTD/sabdagacor.jpg" />
<link rel="manifest" href="https://g.lazcdn.com/g/lzdfe/pwa-assets/5.0.7/manifest/id.json">
<link rel="shortcut icon" href="https://lzd-img-global.slatic.net/g/tps/tfs/TB1PApewFT7gK0jSZFpXXaTkpXa-200-200.png" />
<link rel="canonical" href="<?php echo $urlPath ?>" />
<link rel="amphtml" href="https://manta-gacor-hari-ini.web.app/?mxwn=<?php echo $BRANDS ?>" />

<link rel="preload" href="https://i.postimg.cc/HW9B4qTD/sabdagacor.jpg" as="image" />
<link rel="preconnect dns-prefetch" href="//cart.lazada.co.id" />
<link rel="preconnect dns-prefetch" href="//acs-m.lazada.co.id" />
<link rel="preconnect dns-prefetch" href="//laz-g-cdn.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//laz-img-cdn.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//assets.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//aeis.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//aeu.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//g.alicdn.com" />
<link rel="preconnect dns-prefetch" href="//arms-retcode-sg.aliyuncs.com" />
<link rel="preconnect dns-prefetch" href="//px-intl.ucweb.com" />
<link rel="preconnect dns-prefetch" href="//sg.mmstat.com" />
<link rel="preconnect dns-prefetch" href="//img.lazcdn.comt" />
<link rel="preconnect dns-prefetch" href="//g.lazcdn.com" />
<link rel="preload" href="//g.lazcdn.com/g/??mtb/lib-promise/3.1.3/polyfillB.js,mtb/lib-mtop/2.5.1/mtop.js,lazada-decorate/lazada-mod-lib/0.0.20/LazadaModLib.min.js" as="script" />
<link rel="preload" href="//g.lazcdn.com/g/woodpeckerx/jssdk??wpkReporter.js,plugins/flow.js,plugins/interface.js,plugins/blank.js" as="script" />
<link rel="preload" href="//g.lazcdn.com/g/??code/npm/@ali/lzd-h5-utils-qs/0.1.11/index.js,code/npm/@ali/lzd-h5-utils-cookie/1.2.10/index.js,code/npm/@ali/lzd-h5-utils-sites/1.1.11/index.js,code/npm/@ali/lzd-h5-utils-env/1.5.12/index.js,code/npm/@ali/lzd-h5-utils-logger/1.1.52/index.js,code/npm/@ali/lzd-h5-utils-jsonp/1.1.11/index.js,code/npm/@ali/lzd-h5-utils-mtop/1.2.56/index.js,code/npm/@ali/lzd-h5-utils-icon/1.0.8/index.js,lzd/assets/1.1.18/require/2.3.6/require.js" as="script" />
<link rel="preload" href="//g.lazcdn.com/g/lzdfe/pdp-platform/0.1.22/pc.css" as="style" />
<link rel="preload" href="//g.lazcdn.com/g/lzdfe/pdp-platform/0.1.22/pc.js" as="script" crossorigin />
<link rel="preload" href="//g.lazcdn.com/g/lzdfe/pdp-modules/1.4.4/pc-mod.css" as="style" />
<link rel="preload" href="//g.lazcdn.com/g/lzdfe/pdp-modules/1.4.4/pc-mod.js" as="script" crossorigin />
<link rel="preload" href="//aeis.alicdn.com/sd/ncpc/nc.js?t=18507" as="script" />
<link rel="preload" href="//g.lazcdn.com/g/alilog/mlog/aplus_int.js" as="script" />
<link rel="preload" href="//g.lazcdn.com/g/retcode/cloud-sdk/bl.js" as="script" crossorigin />
<link rel="preload" href="//g.lazcdn.com/g/lzd/assets/1.1.37/web-vitals/2.1.0/index.js" as="script" />

<link rel="stylesheet" href="//g.lazcdn.com/g/??lzd/assets/0.0.7/dpl-buyeruikit/2.0.1/next-noreset-1.css,lzd/assets/0.0.7/dpl-buyeruikit/2.0.1/next-noreset-2.css,lazada/lazada-product-detail/1.7.4/index/index.css">
<!--[if lte IE 9]><link rel="stylesheet" href="//g.lazcdn.com/g/lzd/assets/1.2.13/dpl-buyeruikit/1.7.0/next-noreset-2.css" /><![endif]-->
<link rel="stylesheet" href="//g.lazcdn.com/g/lzdfe/pdp-platform/0.1.22/pc.css" />
<link rel="stylesheet" href="//g.lazcdn.com/g/lzdfe/pdp-modules/1.4.4/pc-mod.css" />
<script type="6c69253c274905671b0ddb2a-text/javascript">
  (function() {
    try {
      if (window.aplusPageIdSetComplete || /AliApp/i.test(navigator.userAgent)) {
        return;
      }
  
      var get_cookie = function (sName) {
        var sRE = '(?:; )?' + sName + '=([^;]*);?';
        var oRE = new RegExp(sRE);
        if (oRE.test(document.cookie)) {
        var str = decodeURIComponent(RegExp['$1']) || '';
        if (str.trim().length > 0) {
          return str;
        } else {
          return '-';
        }
        } else {
          return '-';
        }
      };
      var getRand = function () {
        var page_id = get_cookie('cna') || '001';
        page_id = page_id.toLowerCase().replace(/[^a-z\d]/g, '');
        page_id = page_id.substring(0, 16);
        var d = (new Date()).getTime();
        var randend = [
          page_id,
          d.toString(16)
        ].join('');
  
        for (var i = 1; i < 10; i++) {
          var _r = parseInt(Math.round(Math.random() * 10000000000), 10).toString(16);
          randend += _r;
        }
        randend = randend.substr(0, 42);
        return randend;
      };
      var pageid = getRand();
      var aq = (window.aplus_queue || (window.aplus_queue = []));
      aq.push({
        'action':'aplus.appendMetaInfo',
        'arguments':['aplus-cpvdata', {"pageid":pageid}]
      });
      aq.push({
        'action':'aplus.appendMetaInfo',
        'arguments':['aplus-exdata',{"st_page_id":pageid}]
      });
      // 兼容老版本aplus
      var gq = (window.goldlog_queue || (window.goldlog_queue = []));
      gq.push({
        'action':'goldlog.appendMetaInfo',
        'arguments':['aplus-cpvdata', {"pageid":pageid}]
      });
      gq.push({
        'action':'goldlog.appendMetaInfo',
        'arguments':['aplus-exdata',{"st_page_id":pageid}]
      });
      window.aplusPageIdSetComplete = true;
    } catch(err) {
      console.error(err);
    }
  })();
  </script>
<script type="6c69253c274905671b0ddb2a-text/javascript">
    var timings = {
      start: Date.now(),
    };
    var dataLayer = window.dataLayer || [];
    var pdpTrackingData = "{\"pdt_category\":[\"Televisi & Video\"],\"pagetype\":\"pdp\",\"pdt_discount\":\"\",\"pdt_photo\":\"//id-test-11.slatic.net/p/c08a6637647b6984097e3fcf63c97c3c.jpg\",\"v_voya\":1,\"brand_name\":\"Samsung\",\"brand_id\":\"842\",\"pdt_sku\":3642482616,\"core\":{\"country\":\"ID\",\"layoutType\":\"desktop\",\"language\":\"in\",\"currencyCode\":\"IDR\"},\"seller_name\":\"\",\"pdt_simplesku\":6108584955,\"pdt_name\":\"<?php echo $BRANDS ?> SITUS RESMI TERPERCAYA - MA Plus Al Hadi Padangan\",\"page\":{\"regCategoryId\":\"300300002584\",\"xParams\":\"_p_typ=pdp&_p_ispdp=1&_p_item=3642482616_ID-6108584955&_p_prod=3642482616&_p_sku=6108584955&_p_slr=\"},\"supplier_id\":\"\",\"pdt_price\":\"Rp2.699.000\"}";
    try {
      pdpTrackingData = JSON.parse(pdpTrackingData);
      pdpTrackingData.v_voya = false;
      dataLayer.push(pdpTrackingData);
      dataLayer.push({
        gtm_enable: false,
        v_voya: false
      });
    } catch (e) {
      if (window.console) {
        console.log(e);
      }
    }
    /**
     * 支持beacon aplus script
     */
    var siteNameForApluPluginLoader = "Lazada";

  </script>

<meta name="X-CSRF-TOKEN" id="X-CSRF-TOKEN" content="eb3380311eeee" />
</head>
<body data-spm="pdp_revamp" style="overflow-y: scroll">
<script type="6c69253c274905671b0ddb2a-text/javascript">window.__lzd__svg__cssinject__ = true;</script>
<style>
  .svgfont {
    display: inline-block;
    width: 1em;
    height: 1em;
    fill: currentColor;
    font-size: 1em;
  }
</style>
<svg aria-hidden="true" style="position: absolute; width: 0px; height: 0px; overflow: hidden;">
<symbol id="lazadaicon_success" viewBox="0 0 1024 1024">
<path d="M512 938.666667c234.666667 0 426.666667-192 426.666667-426.666667s-192-426.666667-426.666667-426.666667-426.666667 192-426.666667 426.666667 192 426.666667 426.666667 426.666667z">
</path>
<path d="M418.133333 691.2c-8.533333 0-12.8-4.266667-21.333333-8.533333l-115.2-115.2c-12.8-12.8-12.8-29.866667 0-38.4 12.8-12.8 29.866667-12.8 38.4 0l93.866667 93.866666 256-247.466666c12.8-12.8 29.866667-12.8 38.4 0s12.8 29.866667 0 38.4l-273.066667 268.8c0 8.533333-8.533333 8.533333-17.066667 8.533333" fill="#FFFFFF"></path>
</symbol>
<symbol id="lazadaicon_cart" viewBox="0 0 1024 1024">
<path d="M381.248 761.344a51.328 51.328 0 1 0 0 102.656 51.328 51.328 0 0 0 0-102.656z m-252.928-118.4v68.416h125.056l-14.88-68.448H128.32z m0-145.824v68.448h92.896l-14.88-68.448H128.32zM377.6 237.12l14.912 68.448h419.616V642.88H384.96L289.6 193.504 128.64 192 128 260.448l106.048 0.992 95.488 449.92h551.04V237.12H377.6z m458.4 575.552a51.328 51.328 0 1 1-102.72 0 51.328 51.328 0 0 1 102.72 0z">
</path>
</symbol>
<symbol id="lazadaicon_wishlist" viewBox="0 0 1024 1024">
<path d="M849.067 233.244c-82.49-82.488-209.067-82.488-291.556 0l-166.4 164.978 52.622 51.2 164.978-164.978c55.467-55.466 135.111-55.466 189.156 0 45.51 45.512 61.155 128 0 189.156l-72.534 72.533L509.156 748.09 292.978 546.133 220.444 473.6c-49.777-56.889-41.244-146.489 0-189.156 51.2-51.2 132.267-52.622 184.89-4.266l51.2-51.2c-81.067-76.8-209.067-75.378-287.29 2.844-65.422 65.422-82.488 200.534-1.422 290.134l75.378 75.377 265.956 248.89 265.955-248.89 73.956-73.955c91.022-89.6 71.11-219.022 0-290.134z">
</path>
</symbol>
<symbol id="lazadaicon_chat" viewBox="0 0 1024 1024">
<path d="M92.471652 820.758261l165.286957-123.547826h666.935652V136.993391H92.449391v683.742609zM0 887.318261l92.471652-66.56v-134.455652L0 741.62087V44.521739h1017.143652v745.160348H283.692522L0 989.807304V887.318261z">
</path>
<path d="M261.988174 275.70087h477.762783v92.471652H261.988174zM261.988174 445.217391h261.988174v92.471652H261.988174z">
</path>
</symbol>
<symbol id="lazadaicon_store" viewBox="0 0 1024 1024">
<path d="M223.833043 141.868522l180.936348 1.669565h332.221218l92.471652-92.471652H405.504L160.723478 48.88487 19.945739 316.549565a142.06887 142.06887 0 0 0 95.654957 188.66087 158.118957 158.118957 0 0 0 134.322087-24.998957l26.37913-24.197565 27.469913 23.863652a159.209739 159.209739 0 0 0 90.445913 28.026435 159.432348 159.432348 0 0 0 111.304348-45.100522l2.381913-2.337391 2.381913 2.337391a159.432348 159.432348 0 0 0 111.304348 45.100522c30.764522 0 59.503304-8.681739 83.878956-23.752348l35.617392-29.874087 34.148174 30.430609a158.029913 158.029913 0 0 0 128.289391 20.813913 142.870261 142.870261 0 0 0 96.478609-188.994783l-92.249044-173.367652-68.608 66.404174 74.48487 139.976348a50.398609 50.398609 0 0 1-34.059131 66.671304 65.958957 65.958957 0 0 1-67.673043-21.370435l-68.741565-81.92-71.123479 79.872a67.072 67.072 0 0 1-50.44313 22.639305 66.982957 66.982957 0 0 1-47.972174-20.034783l-65.714087-66.404174-65.736348 66.426435c-12.644174 12.777739-29.606957 20.012522-47.949913 20.012522a67.049739 67.049739 0 0 1-49.775304-21.904696l-70.010435-76.354782-67.940174 78.202434a65.936696 65.936696 0 0 1-66.960696 20.524522 49.597217 49.597217 0 0 1-33.391304-65.869913l117.693217-208.161391z">
</path>
<path d="M184.943304 876.744348V445.217391H92.471652v523.976348h832.200348V445.217391h-92.449391v431.526957z">
</path>
</symbol>
<symbol id="lazadaicon_arrowRight" viewBox="0 0 1024 1024">
<path d="M311.466667 814.933333l68.266666 59.733334 332.8-366.933334-332.8-358.4-64 59.733334 273.066667 298.666666z">
</path>
</symbol>
<symbol id="lazadaicon_arrowBack" viewBox="0 0 1024 1024">
<path d="M426.666667 507.733333L763.733333 170.666667l-85.333333-85.333334L256 507.733333l4.266667 4.266667 422.4 422.4 85.333333-85.333333-341.333333-341.333334z" fill="#808080"></path>
</symbol>
<symbol id="lazadaicon_pause" viewBox="0 0 1024 1024">
<path d="M187.733333 102.4h256v819.2H187.733333zM597.333333 102.4h256v819.2H597.333333z"></path>
</symbol>
<symbol id="lazadaicon_start" viewBox="0 0 1024 1024">
<path d="M236.249425 10.759014l591.395068 460.126685a42.082192 42.082192 0 0 1 0.490959 66.055013l-591.395068 474.266302A42.082192 42.082192 0 0 1 168.328767 978.396932V43.989918A42.082192 42.082192 0 0 1 236.249425 10.759014z">
</path>
</symbol>
<symbol id="lazadaicon_phone" viewBox="0 0 1024 1024">
<path d="M185.6 21.333333v85.333334h567.466667v29.866666H185.6v874.666667h652.8V21.333333H185.6z m567.466667 904.533334H270.933333v-123.733334h482.133334v123.733334z m0-206.933334H270.933333V221.866667h482.133334v497.066666z" fill></path>
<path d="M512 864m-42.666667 0a42.666667 42.666667 0 1 0 85.333334 0 42.666667 42.666667 0 1 0-85.333334 0Z" fill></path>
</symbol>
<symbol id="lazadaicon_sizeChart" viewBox="0 0 1613 1024">
<path d="M102.4 68.267h1405.673v893.672H102.4V68.267z m89.988 803.685h1225.697V158.255H192.388v713.697z m294.788 0h-89.988V425.115h89.988v446.837z m363.054 0h-89.988V605.09h89.988v266.86z m359.952 0h-89.988V425.115h89.988v446.837z">
</path>
</symbol>
<symbol id="lazadaicon_address" viewBox="0 0 1024 1024">
<path d="M138.971 980.114H43.886V190.171h412.038v95.086H138.97V885.03h599.772V694.857h95.086v285.257H138.97z">
</path>
<path d="M980.114 343.771c065.829-21.943 124.343-70.704 170.667-31.696 31.695-68.267 53.638-112.153 63.39l-351.086 65.83c-9.752 2.437-19.504-7.315-17.066-17.068l70.705-341.333c0-2.438 2.438-7.314 2.438-7.314 9.752-41.448 31.695-75.581 63.39-107.276 46.324-48.762 104.838-70.705 170.667-70.705s124.343 24.38 170.666 73.143c48.762 46.324 73.143 102.4 73.143 170.666z m-190.171-58.514C770.438 265.752 748.495 256 721.676 256c-26.819 0-48.762 9.752-65.828 26.819-19.505 19.505-26.82 41.448-26.82 68.267 0 26.819 9.753 48.762 29.258 68.266 19.504 19.505 41.447 29.258 68.266 29.258 26.82 0 48.762-9.753 68.267-26.82 19.505-19.504 26.82-41.447 26.82-65.828-2.439-29.257-12.191-51.2-31.696-70.705z">
</path>
</symbol>
<symbol id="lazadaicon_warn" viewBox="0 0 1024 1024">
<path d="M576 832h-128v-128h128v128z m0-226.133333h-128v-384h128v384zM512 0C230.4 0 0 230.4 0 512s230.4 512 512 512 512-230.4 512-512S793.6 0 512 0z" fill="#FF9000"></path>
</symbol>
<symbol id="lazadaicon_pin" viewBox="0 0 1024 1024">
<path d="M512 544c64 0 118.4-51.2 118.4-115.2S576 313.6 512 313.6s-118.4 51.2-118.4 115.2S448 544 512 544z m0 345.6l-25.6-25.6c-28.8-28.8-268.8-297.6-268.8-444.8 0-156.8 131.2-284.8 291.2-284.8s291.2 128 291.2 284.8c0 147.2-240 416-268.8 444.8l-19.2 25.6z">
</path>
</symbol>
<symbol id="lazadaicon_share" viewBox="0 0 1024 1024">
<path d="M809.344 695.369143c-44.580571 0-85.101714 17.792-113.481143 49.243428L340.553143 535.332571a101.193143 101.193143 0 0 0 0-49.243428l355.309714-207.908572a152.246857 152.246857 0 0 0 113.481143 50.614858c86.473143-1.371429 151.314286-67.035429 152.667429-154.569143C960.658286 86.674286 895.817143 19.657143 809.344 18.285714c-86.454857 1.371429-152.667429 68.388571-154.002286 155.940572 0 9.563429 1.334857 19.145143 2.688 28.708571L305.426286 408.137143c-28.379429-31.451429-67.547429-51.968-114.834286-51.968-86.473143 1.353143-152.685714 67.017143-154.020571 154.569143 1.353143 87.533714 67.547429 153.197714 154.020571 154.550857 44.580571 0 86.454857-20.516571 114.834286-51.968l352.603428 206.537143c-1.334857 9.581714-2.688 19.163429-2.688 30.098285 1.334857 87.552 67.547429 153.197714 154.002286 154.569143 86.473143-1.371429 151.314286-67.017143 152.667429-154.569143-1.353143-87.533714-66.194286-153.197714-152.667429-154.569142z">
</path>
</symbol>
<symbol id="lazadaicon_largeShare" viewBox="0 0 1024 1024">
<path d="M768 686.933333c-34.133333 0-59.733333 12.8-85.333333 34.133334l-302.933334-179.2c4.266667-8.533333 4.266667-17.066667 4.266667-29.866667 0-8.533333 0-21.333333-4.266667-29.866667L682.666667 307.2c21.333333 21.333333 51.2 34.133333 85.333333 34.133333 72.533333 0 128-55.466667 128-128s-55.466667-128-128-128-128 55.466667-128 128c0 8.533333 0 21.333333 4.266667 29.866667L341.333333 418.133333C320 396.8 290.133333 384 256 384c-72.533333 0-128 55.466667-128 128s55.466667 128 128 128c34.133333 0 64-12.8 85.333333-34.133333l302.933334 179.2c-4.266667 8.533333-4.266667 17.066667-4.266667 29.866666 0 68.266667 55.466667 123.733333 123.733333 123.733334s123.733333-55.466667 123.733334-123.733334c4.266667-68.266667-51.2-128-119.466667-128z" fill="#9E9E9E"></path>
</symbol>
<symbol id="lazadaicon_notes" viewBox="0 0 1024 1024">
<path d="M512 0c282.624 0 512 229.376 512 512s-229.376 512-512 512S0 794.624 0 512 229.376 0 512 0zM460.8 768h102.4V460.8H460.8v307.2z m0-409.6h102.4V256H460.8v102.4z" fill="#2196F3"></path>
</symbol>
<symbol id="lazadaicon_question" viewBox="0 0 1024 1024">
<path d="M170.666667 85.333333c-46.933333 0-85.333333 38.4-85.333334 85.333334v768l170.666667-170.666667h597.333333c46.933333 0 85.333333-38.4 85.333334-85.333333V170.666667c0-46.933333-38.4-85.333333-85.333334-85.333334H170.666667z m512 320c0 34.133333-4.266667 64-17.066667 89.6-12.8 25.6-25.6 42.666667-46.933333 59.733334l59.733333 46.933333-34.133333 38.4-76.8-59.733333c-8.533333 4.266667-21.333333 4.266667-34.133334 4.266666-29.866667 0-55.466667-8.533333-76.8-21.333333s-38.4-34.133333-51.2-59.733333c-12.8-29.866667-21.333333-59.733333-21.333333-93.866667v-21.333333c0-34.133333 4.266667-64 17.066667-93.866667 12.8-25.6 29.866667-46.933333 51.2-59.733333s51.2-21.333333 81.066666-21.333334 55.466667 8.533333 76.8 21.333334 38.4 34.133333 51.2 59.733333 21.333333 59.733333 21.333334 93.866667v17.066666z m-64-17.066666c0-38.4-8.533333-72.533333-21.333334-93.866667-17.066667-21.333333-38.4-29.866667-64-29.866667s-46.933333 12.8-64 34.133334c-12.8 21.333333-21.333333 51.2-21.333333 89.6v21.333333c0 38.4 8.533333 68.266667 21.333333 89.6s38.4 34.133333 64 34.133333c29.86
