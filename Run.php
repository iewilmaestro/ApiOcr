<?php
class rushbit{
	public function __construct(){
		$this->url="https://rushbitcoin.com";
		$this->api=[
			"dash"=>"/",
			"page"=>"/?page=ptc",
			"surf"=>"/surf.php",
			"libs"=>"/system/libs/captcha/request.php",
			"ajax"=>"/system/ajax.php"
			];
		}
	public function HeadA(){
		$cookie=self::Save('Cookie');
		$ua = array();
		$ua[]="cookie: ".$cookie;
		$ua[]="user-agent: Mozilla/5.0 (Linux; Android 9; Redmi 6A) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.99 Mobile Safari/537.36";
		return $ua;
		}
	public function HeadB(){
		$ua = array();
		$ua[]="Host: api-secure.solvemedia.com";
		$ua[]="user-agent: Mozilla/5.0 (Linux; Android 9; Redmi 6A) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.99 Mobile Safari/537.36";
		$ua[]="accept: */*";
		$ua[]="referer: ".$this->url.$this->api['dash'];
		return $ua;
		}
	private function Run($url, $ua, $data = null) {
		while (True){
			$ch = curl_init();
			curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
            CURLOPT_FOLLOWLOCATION => 1,));
            if ($data){
            	curl_setopt_array($ch, array(
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data,));
                }
                curl_setopt_array($ch, array(
                CURLOPT_HTTPHEADER => $ua,
                CURLOPT_SSL_VERIFYPEER => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_COOKIEJAR => 'cookie.txt',
                CURLOPT_COOKIEFILE => 'cookie.txt',));
                $run = curl_exec($ch);
                curl_close($ch);
                return $run;
                }
            }
    public function Save($namadata){
    	if(file_exists($namadata)){
    	$datauser=file_get_contents($namadata);
    	}else{
    	$datauser=readline(self::col("Input ".$namadata,"rp1").self::col(' ≽','m')."\n");
        file_put_contents($namadata,$datauser);
		}
	    return $datauser;
	    }
	public function col($str,$color){
		if($color==5){$color=['h','k','b','u','m'][array_rand(['h','k','b','u','m'])];}
		$war=array('rw'=>"\033[107m\033[1;31m",'rt'=>"\033[106m\033[1;31m",'ht'=>"\033[0;30m",'p'=>"\033[1;37m",'a'=>"\033[1;30m",'m'=>"\033[1;31m",'h'=>"\033[1;32m",'k'=>"\033[1;33m",'b'=>"\033[1;34m",'u'=>"\033[1;35m",'c'=>"\033[1;36m",'rr'=>"\033[101m\033[1;37m",'rg'=>"\033[102m\033[1;34m",'ry'=>"\033[103m\033[1;30m",'rp1'=>"\033[104m\033[1;37m",'rp2'=>"\033[105m\033[1;37m");return $war[$color].$str."\033[0m";}
	public function tmr($tmr){
		$timr=time()+$tmr; 
		while(true): 
		echo "\r                       \r"; 
		$res=$timr-time(); 
		if($res < 1){break;} 
		echo self::col("Next Claim In ",5).self::col("≽ ",'p').self::col(date('H:i:s',$res),5);
		sleep(1); 
		endwhile;
		}
	public function Dash(){
		$url=$this->url.$this->api["dash"];
		return self::Run($url,$this->HeadA());
		}
	public function Solv(){
		$url="https://api-secure.solvemedia.com/papi/_challenge.js?k=WHx3UGDFc-pSG5USBRCcorQmj9JijaLj;f=_ACPuzzleUtil.callbacks%5B0%5D;l=en;t=img;s=standard;c=js,h5c,h5ct,svg,h5v,v/64,v/webm,h5a,a/mp3,a/ogg,ua/chrome,ua/chrome80,os/android,os/android9,fwv/BQ9big.duqs17,jslib/jquery,htmlplus;am=u3sGXwCCTHO-dPW.AIJMcw;ca=ajax;ts=1635401711;ct=1635424133;th=white;r=0.14074429362538976";
		return self::Run($url,$this->HeadB());
		}
	public function Media($ca){
		$url='https://api-secure.solvemedia.com/papi/media?c='.$ca.';w=300;h=150;fg=000000;bg=f8f8f8';
		return self::Run($url,$this->HeadB());
		}
	public function Ajax($token,$ca,$cap){
		$url=$this->url.$this->api['ajax'];
		$dt="a=getFaucet&token=".$token."&captcha=0&challenge=".$ca."&response=".$cap;
		return json_decode(self::Run($url,$this->HeadA(),$dt));
		}
	}
class iewil extends rushbit{
	public function bn(){
		echo self::col("Script by ","h")." iewil\n\n";
		}
	public function _run(){
		//error_reporting(0);
		system('clear');
		self::bn();
		self::Save('Cookie');
		$user= explode('</font>',explode('<font class="text-success">',$this->Dash())[1])[0];
		preg_match('#<div class="col-9 no-space">(.*?)<div class="text-primary"><b>(.*?)</b>#is',$this->Dash(),$bal);
		if($user){
			echo "Username ".self::col('-> ','m').$user."\n";
			echo $bal[1].self::col('-> ','m').$bal[2]."\n\n";
			
			while(true){
				echo self::col('try','k');
				$token = explode("'",explode("var token = '",$this->Dash())[1])[0];
				$chal=explode('"',$this->Solv())[5];
				$media=$this->Media($chal);
				file_put_contents("img.jpg",$media);
				system('convert img.jpg -gravity North -chop x15 captcha.png 2>/dev/null');
				$hasil=json_decode(shell_exec('curl --silent -H "apikey:eb487692b488957" --form "file=@captcha.png" --form "language=eng" --form "ocrengine=2" --form "isOverlayRequired=false" --form "iscreatesearchablepdf=false" https://api.ocr.space/Parse/Image'))->ParsedResults[0]->ParsedText;
				$cap = preg_replace("/[^a-zA-Z]/","", $hasil);
				$ajax=$this->Ajax($token,$chal,$cap);
				if($ajax->status == 0){
					echo "\r                                                              \r";
					echo self::col("Please confirm you're not a robot!","m");
					sleep(2);
					echo "\r                                                              \r";
				}else{
					echo "\r                                                              \r";
					$ss=trim(str_replace('</div>','',explode('</i> Congratulations,',$ajax->message)[1]));
					echo self::col($ss,'k')."\n";
					echo str_repeat('~',66)."\n";
					$this->tmr(300);
					}
				}
			}
		}
	}
	
$obj=new iewil;
$obj->_run();
?>