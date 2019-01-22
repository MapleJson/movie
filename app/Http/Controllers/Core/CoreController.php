<?php
namespace App\Http\Controllers\Core;

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Common\SystemCotroller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use QL\Ext\CurlMulti;
use QL\QueryList;
class CoreController extends Controller
{
	private $ql;
	private $common;
	private $domin;
	private $opts = array('headers' => array('User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'));
	private $vinfo = array();
	private $search = array();
	public function __construct()
	{
		$this->ql = new QueryList();
		$this->ql->use(CurlMulti::class);
		$this->domin = 'https://www.360kan.com';
		$this->common = new CommonController();
	}
	public function indexDsCollect()
	{
		$_var_0 = ['title' => ['ul:eq(10) .s1', 'text', ''], 'url' => ['ul:eq(10) a.js-link', 'href', ''], 'img' => ['ul:eq(10) .js-playicon img', 'data-src', ''], 'pf' => ['ul:eq(10) .s2', 'text', ''], 'js' => ['ul:eq(10) .w-newfigure-hint', 'text']];
		$_var_1 = $this->ql->get($this->domin, '', $this->opts)->rules($_var_0)->query()->getData();
		$this->ql->destruct();
		return $_var_1->all();
	}
	public function dyList($_var_2, $_var_3)
	{
		if ($_var_2 == 101) {
			die('未找到相应资源');
		}
		$_var_4 = $this->domin . '/dianying/list?rank=rankhot&cat=' . $_var_2 . '&area=all&act=all&year=all&pageno=' . $_var_3;
		$_var_5 = ['title' => ['.list.g-clear .s1', 'text', ''], 'url' => ['.list.g-clear a.js-tongjic', 'href', '', function ($_var_6) {
			return base64_encode($this->domin . $_var_6);
		}], 'img' => ['.list.g-clear .cover.g-playicon img', 'src', ''], 'pf' => ['.point', 'text', ''], 'year' => ['.list.g-clear .hint', 'text'], 'star' => ['.list.g-clear .star', 'text', '']];
		$_var_7 = $this->ql->get($_var_4)->rules($_var_5)->query()->getData();
		$this->ql->destruct();
		return $_var_7->all();
	}
	public function dsjList($_var_8, $_var_9)
	{
		$_var_10 = $this->domin . '/dianshi/list?rank=rankhot&cat=' . $_var_8 . '&area=all&act=all&year=all&pageno=' . $_var_9;
		$_var_11 = ['title' => ['.list.g-clear .s1', 'text', ''], 'url' => ['.list.g-clear a.js-tongjic', 'href', '', function ($_var_12) {
			return base64_encode($this->domin . $_var_12);
		}], 'img' => ['.list.g-clear .cover.g-playicon img', 'src', ''], 'js' => ['.list.g-clear .hint', 'text', ''], 'star' => ['.list.g-clear .star', 'text', '']];
		$_var_13 = $this->ql->get($_var_10)->rules($_var_11)->query()->getData();
		$this->ql->destruct();
		return $_var_13->all();
	}
	public function zyList($_var_14, $_var_15)
	{
		$_var_16 = $this->domin . '/zongyi/list?rank=rankhot&cat=' . $_var_14 . '&area=all&act=all&pageno=' . $_var_15;
		$_var_17 = ['title' => ['.list.g-clear .s1', 'text', ''], 'url' => ['.list.g-clear a.js-tongjic', 'href', '', function ($_var_18) {
			return base64_encode($this->domin . $_var_18);
		}], 'img' => ['.list.g-clear .cover.g-playicon img', 'src', ''], 'js' => ['.list.g-clear .hint', 'text', ''], 'star' => ['.list.g-clear .star', 'text', '']];
		$_var_19 = $this->ql->get($_var_16)->rules($_var_17)->query()->getData();
		$this->ql->destruct();
		return $_var_19->all();
	}
	public function dmList($_var_20, $_var_21)
	{
		$_var_22 = $this->domin . '/dongman/list?rank=rankhot&cat=' . $_var_20 . '&area=all&act=all&pageno=' . $_var_21;
		$_var_23 = ['title' => ['.list.g-clear .s1', 'text', ''], 'url' => ['.list.g-clear a.js-tongjic', 'href', '', function ($_var_24) {
			return base64_encode($this->domin . $_var_24);
		}], 'img' => ['.list.g-clear .cover.g-playicon img', 'src', ''], 'js' => ['.list.g-clear .hint', 'text', '']];
		$_var_25 = $this->ql->get($_var_22)->rules($_var_23)->query()->getData();
		$this->ql->destruct();
		return $_var_25->all();
	}
	public function getDyPlay($_var_26)
	{
		$_var_27 = ['title' => ['.title-left.g-clear h1', 'text', ''], 'desc' => ['.js-close-wrap', 'text', '-span'], 'playname' => ['.top-list-zd.g-clear a[data-daochu^="to="]', 'text', '-span'], 'play' => ['.top-list-zd.g-clear a[data-daochu^="to="]', 'href', '', function ($_var_28) {
			if (strpos($_var_28, 'cps') && strpos($_var_28, 'youku')) {
				$_var_29 = explode('&', $_var_28);
				$_var_30 = str_replace('url=', '', $_var_29['1']);
				return $_var_30;
			} else {
				if (strpos($_var_28, '?')) {
					$_var_31 = strpos($_var_28, '?');
					return substr($_var_28, 0, $_var_31);
				} else {
					return $_var_28;
				}
			}
		}]];
		$_var_32 = $this->ql->get($_var_26)->rules($_var_27)->query()->getData();
		$this->ql->destruct();
		return $_var_32->all();
	}
	public function getDsjPlay($_var_33)
	{
		$_var_34 = ['title' => ['.title-left.g-clear h1', 'text', ''], 'desc' => ['.js-close-wrap', 'text', '-span']];
		$_var_35 = $this->ql->get($_var_33)->rules($_var_34)->query()->getData();
		$this->ql->destruct();
		return $_var_35->all();
	}
	public function getZyPlay($_var_36)
	{
		$_var_37 = ['bt' => ['.title-left.g-clear h1', 'text', ''], 'zd' => ['.ea-site', 'text', ''], 'desc' => ['.js-close-wrap', 'text', '-span'], 'title' => ['.js-year-page .s1', 'text', ''], 'href' => ['.juji-main a.js-link', 'href'], 'time' => ['.juji-main .w-newfigure-hint', 'text', '']];
		$_var_38 = $this->ql->get($_var_36)->rules($_var_37)->query()->getData();
		$this->ql->destruct();
		return $_var_38->all();
	}
	public function getLike($_var_39)
	{
		$_var_40 = ['title' => ['.s-guess-list .title', 'text', ''], 'url' => ['.s-guess-list .title a', 'href', '', function ($_var_41) {
			return base64_encode($this->domin . $_var_41);
		}], 'img' =>['.s-guess-list li .js-playicon img', 'data-src', '']];
		$_var_42 = $this->ql->get($_var_39)->rules($_var_40)->query()->getData();
		$this->ql->destruct();
		return $_var_42->all();
	}
	public function getTDLike($_var_43 = 'tv', $_var_44)
	{
		if ($_var_43 == 'tv') {
			$_var_45 = ['title' => ['.s-guess-list .title', 'text', ''], 'url' => ['.s-guess-list .title a', 'href', '', function ($_var_46) {
				return base64_encode($this->domin . $_var_46);
			}], 'img' => ['.s-guess-list li .js-playicon img', 'data-src', '']];
		} else {
			$_var_45 = ['title' => ['.s-guess-list .title', 'text', ''], 'url' => ['.s-guess-list .title a', 'href', '', function ($_var_47) {
				return base64_encode($this->domin . $_var_47);
			}], 'img' => ['.s-guess-list li .js-playicon img', 'data-src', '']];
		}
		$_var_48 = $this->ql->get($_var_44)->rules($_var_45)->query()->getData();
		return $_var_48->all();
	}
	public function getSearch($_var_49, $_var_50 = "")
	{
		$_var_51 = 'https://so.360kan.com/index.php?kw=' . $_var_49;
		$_var_52 = ['dy_title' => ['.m-mainpic a', 'title', ''], 'dy_addr' => ['.m-mainpic a', 'href', '', function ($_var_53) use($_var_50) {
			$_var_54 = str_replace('http://', 'https://', $_var_53);
			if ($_var_50 == 'wx') {
				return 'http://' . config('webset.webdomin') . '/play/' . base64_encode($_var_53) . '.html';
			}
			return base64_encode($_var_54);
		}], 'dy_img' => ['.m-mainpic img', 'src', ''], 'dy_type' => ['.cont .playtype', 'text', ''], 'dy_desc' => ['.m-description', 'text','-i'], 'dy_pf' => ['.cont .m-score', 'text', ''],'dy_zy' => ['.cont .actor', 'text', '-b'],'dy_qj' => ['.m-series', 'text', '']];
		$_var_55 = $this->ql->get($_var_51)->rules($_var_52)->query()->getData();
		$this->ql->destruct();
		return $_var_55->all();
	}
	public function getTotal()
	{
		$_var_56 = $this->domin . '/dianshi/list.php';
		$_var_57 = ['total' => ['.app span', 'text', '']];
		$_var_58 = $this->ql->get($_var_56)->rules($_var_57)->query()->getData();
		$this->ql->destruct();
		return $_var_58->all();
	}
	public function getCx($_var_59, $_var_60)
	{
		$_var_61 = 'http://' . $_var_60 . '/index.php?m=vod-search';
		$_var_62 = ['wd' => $_var_59, 'submit' => 'search'];
		$_var_63 = $this->common->curl_post($_var_61, $_var_62);
		$_var_64 = ['title' => ['.xing_vb4 a', 'text', '-span'], 'url' => ['.xing_vb4 a', 'href', '']];
		$_var_65 = $this->ql->html($_var_63)->rules($_var_64)->query()->getData();
		$this->ql->destruct();
		$_var_66 = $_var_65->all();
		foreach ($_var_66 as $_var_59 => $_var_67) {
			$_var_67['url'] = 'http://' . $_var_60 . $_var_67['url'];
			$_var_66[$_var_59]['url'] = $_var_67['url'];
		}
		return $_var_66;
	}
	public function autoCxSearch($_var_68, $_var_69, $_var_70 = '')
	{
		$_var_71 = 'http://' . $_var_69 . '/index.php?m=vod-search';
		$_var_72 = ['wd' => $_var_68, 'submit' => 'search'];
		$_var_73 = $this->common->curl_post($_var_71, $_var_72);
		$_var_74 = ['title' => ['.xing_vb4 a', 'text', '-span'], 'url' => ['.xing_vb4 a', 'href', ''], 'type' => ['.xing_vb5', 'text', '']];
		$_var_75 = [];
		$_var_76 = $this->ql->html($_var_73)->rules($_var_74)->query()->getData();
		$_var_77 = $_var_76->all();
		foreach ($_var_77 as $_var_68 => $_var_78) {
			if (mb_strpos($_var_78['type'], '伦理') === false) {
				$_var_78['url'] = 'http://' . $_var_69 . $_var_78['url'];
				$_var_75[] = $_var_78['url'];
			}
		}
		$_var_79 = ['dy_addr' => ['.nvc dl dd a:eq(2)', 'href', '', function ($_var_80) use($_var_70) {
			if ($_var_70 == 'wx') {
				return 'http://' . config('webset.webdomin') . '/play/' . base64_encode($_var_80) . '.html';
			}
			return base64_encode($_var_80);
		}], 'dy_title' => ['.vodh h2', 'text'], 'dy_cxpff' => ['.vodh label', 'text', ''], 'dy_cxzt' => ['.vodh span', 'text', ''], 'dy_cxdy' => ['.vodinfobox ul li:eq(1) span', 'text', ''], 'dy_star' => ['.vodinfobox ul li:eq(2) span', 'text', ''], 'dy_starr' => ['.vodinfobox ul li:eq(3) span', 'text', ''], 'dy_cxdq' => ['.vodinfobox ul li:eq(4) span', 'text', ''], 'dy_cxsj' => ['.vodinfobox ul li:eq(6) span', 'text', ''], 'dy_desc' => ['.vodplayinfo:eq(1)', 'text', ''], 'dy_img' => ['.lazy', 'src']];
		if ($_var_69 == 'www.go1977.com') {
			$_var_79 = ['dy_addr' => ['.nvc dl dd a:eq(2)', 'href', '', function ($_var_81) use($_var_70) {
				if ($_var_70 == 'wx') {
					return 'http://' . config('webset.webdomin') . '/play/' . base64_encode($_var_81) . '.html';
				}
				return base64_encode($_var_81);
			}], 'dy_title' => ['.vodh h2', 'text'], 'dy_star' => ['.vodinfobox ul li span', 'text', ''], 'dy_desc' => ['.vodplayinfo:eq(0)', 'text', ''], 'dy_img' => ['.lazy', 'src']];
		}
		$this->ql->rules($_var_79)->curlMulti($_var_75)->success(function (QueryList $_var_82) {
			$_var_83 = $_var_82->query()->getData();
			$_var_84 = $_var_83->all();
			$this->search[] = $_var_84;
			$_var_82->destruct();
		})->start(['maxThread' => 100, 'maxTry' => 3, 'opt' => [CURLOPT_TIMEOUT => 10, CURLOPT_CONNECTTIMEOUT => 1, CURLOPT_RETURNTRANSFER => true], 'cache' => ['enable' => true, 'compress' => true, 'dir' => 'storage/app/public/cache', 'expire' => 86400, 'verifyPost' => false]]);
		$_var_85 = [];
		$_var_86 = $this->search;
		foreach ($_var_86 as $_var_78) {
			$_var_85[] = $_var_78[0];
		}
		return $_var_85;
	}
	public function getCxData($_var_87)
	{
		$_var_88 = ['dyname' => ['.vodh h2', 'text'], 'dydesc' => ['.vodplayinfo:eq(1)', 'text', ''], 'dylogo' => ['.lazy', 'src']];
		if (strpos($_var_87, 'www.go1977.com') !== false) {
			$_var_88 = ['dyname' => ['.vodh h2', 'text'], 'dydesc' => ['.vodplayinfo:eq(0)', 'text', ''], 'dylogo' => ['.lazy', 'src']];
		}
		$_var_89 = $this->ql->get($_var_87)->rules($_var_88)->query()->getData();
		$this->ql->destruct();
		return $_var_89->all();
	}
	public function getCxLink($_var_90, $_var_91 = '')
	{
		$_var_92 = [];
		$_var_93 = [];
		$_var_94 = [];
		$_var_95 = [];
		$_var_96 = 1;
		$_var_97 = 1;
		$_var_98 = 1;
		$_var_99 = ['dyaddr' => ['input', 'value', '']];
		$_var_100 = $this->ql->get($_var_90)->rules($_var_99)->range('.vodplayinfo ul>li')->query()->getData();
		$this->ql->destruct();
		$_var_101 = $_var_100->all();
		if (count($_var_101) > 3) {
			foreach ($_var_101 as $_var_102) {
				if (strpos($_var_102['dyaddr'], 'm3u8')) {
					$_var_93[] = '第' . $_var_96++ . '集$' . (config('playerconfig.m3u8') ?? '/public/player/player.php?url=') . $_var_102['dyaddr'];
				} elseif (strpos($_var_102['dyaddr'], 'mp4')) {
					$_var_95[] = '第' . $_var_97++ . '集$' . (config('playerconfig.mp4') ?? '/public/player/player.php?url=') . $_var_102['dyaddr'];
				} else {
					$_var_94[] = '第' . $_var_98++ . '集$' . $_var_102['dyaddr'];
				}
			}
		} else {
			foreach ($_var_101 as $_var_102) {
				if (strpos($_var_102['dyaddr'], 'm3u8')) {
					$_var_93[] = '超清HD$' . (config('playerconfig.m3u8') ?? '/public/player/player.php?url=') . $_var_102['dyaddr'];
				} elseif (strpos($_var_102['dyaddr'], 'mp4')) {
					$_var_95[] = '超清HD$' . (config('playerconfig.mp4') ?? '/public/player/player.php?url=') . $_var_102['dyaddr'];
				} else {
					$_var_94[] = '超清HD$' . $_var_102['dyaddr'];
				}
			}
		}
		switch ($_var_91) {
			case 'm3u8':
				return $_var_93;
				break;
			case 'mp4':
				return $_var_95;
				break;
			case 'zhilian':
				return $_var_94;
				break;
			case 'total':
				if ($_var_93) {
					$_var_92['m3u8'] = $_var_93;
				}
				if ($_var_95) {
					$_var_92['mp4'] = $_var_95;
				}
				if ($_var_94) {
					$_var_92['zhilian'] = $_var_94;
				}
				return $_var_92;
				break;
		}
	}
	public function AutoCxList(Request $_var_103, $_var_104, $_var_105, $_var_106)
	{
		$_var_107 = 'http://' . $_var_104 . '/?m=vod-type-id-' . $_var_105 . '-pg-' . $_var_106 . '.html';
		$_var_108 = [];
		$_var_109 = ['link' => ['.xing_vb4 a', 'href', '', function ($_var_110) use($_var_104) {
			return 'http://' . $_var_104 . $_var_110;
		}]];
		$_var_111 = $this->ql->get($_var_107)->rules($_var_109)->query()->getData()->all();
		foreach ($_var_111 as $_var_112) {
			$_var_108[] = $_var_112['link'];
		}
		$_var_113 = ['dy_addr' => ['.nvc dl dd a:eq(2)', 'href', '', function ($_var_114) {
			return base64_encode($_var_114);
		}], 'dy_title' => ['.vodh h2', 'text'], 'dy_star' => ['.vodinfobox ul li:eq(2) span', 'text', ''], 'dy_img' => ['.lazy', 'src']];
		$this->ql->rules($_var_113)->curlMulti($_var_108)->success(function (QueryList $_var_115) {
			$_var_116 = $_var_115->query()->getData();
			$_var_117 = $_var_116->all();
			$this->vinfo[] = $_var_117;
			$_var_115->destruct();
		})->start(['maxThread' => 100, 'maxTry' => 3, 'opt' => [CURLOPT_TIMEOUT => 10, CURLOPT_CONNECTTIMEOUT => 1, CURLOPT_RETURNTRANSFER => true], 'cache' => ['enable' => true, 'compress' => true, 'dir' => 'storage/app/public/cache', 'expire' => 86400, 'verifyPost' => false]]);
		return $this->vinfo;
	}
	public function getWxSearch($_var_118)
	{
		$_var_119 = '';
		$_var_120 = [];
		$_var_121 = 'http://api.t.sina.com.cn/short_url/shorten.json?source=' . config('wxconfig.sina_app_key');
		$_var_122 = config('autocxconfig.dizhi');
		$_var_119 = $this->getSearch($_var_118, 'wx');
		$_var_123 = $this->autoCxSearch($_var_118, $_var_122, 'wx');
		$_var_124 = ['dy_title' => config('wxconfig.twtitle'), 'dy_img' => config('wxconfig.reimg'), 'dy_addr' => 'http://' . config('webset.webdomin') . '/search/' . urlencode($_var_118) . '.html'];
		if (!empty($_var_123)) {
			foreach ($_var_123 as $_var_125) {
				array_unshift($_var_119, $_var_125);
			}
		}
		if (!empty($_var_119) || !empty($_var_123)) {
			array_unshift($_var_119, $_var_124);
		}
		if (!empty($_var_119)) {
			$_var_126 = count($_var_119);
			if (config('wxconfig.fanghong')) {
				if ($_var_126 >= 4) {
					for ($_var_127 = 0; $_var_127 < 4; $_var_127++) {
						$_var_121 .= '&url_long=' . $_var_119[$_var_127]['dy_addr'];
					}
					$_var_128 = $this->common->curl_get_dwz($_var_121);
					$_var_129 = json_decode($_var_128, 1);
					foreach ($_var_129 as $_var_118 => $_var_125) {
						$_var_120[$_var_118] = $_var_119[$_var_118];
						$_var_120[$_var_118]['dy_addr'] = $_var_125['url_short'];
					}
					return $_var_120;
				} else {
					for ($_var_127 = 0; $_var_127 < $_var_126; $_var_127++) {
						$_var_121 .= '&url_long=' . $_var_119[$_var_127]['dy_addr'];
					}
					$_var_128 = $this->common->curl_get_dwz($_var_121);
					$_var_129 = json_decode($_var_128, 1);
					foreach ($_var_129 as $_var_118 => $_var_125) {
						$_var_120[$_var_118] = $_var_119[$_var_118];
						$_var_120[$_var_118]['dy_addr'] = $_var_125['url_short'];
					}
					return $_var_120;
				}
			} else {
				return $_var_119;
			}
		}
	}
}