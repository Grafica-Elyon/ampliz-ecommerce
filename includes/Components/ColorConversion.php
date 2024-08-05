<?php
namespace MisterPrint\Components;
use Carbon\Carbon;

class ColorConversion extends Component{

	//criando pasta e salvando arquivos
	public static function gerarCmyk(){
	    sleep(2);
		$data = $_POST;
		$userId = user()->getId();
		$savedName = get_id_loja()."-".$userId."-".date("Ymd-His");
		$foto1 = null;
		$foto2 = null;
		\MisterPrint\Helper\Log::info("dados no color: ".json_encode($data['data']));
	 	//cria pasta dos arquivos
		$pastaUpload = '/public_html/uploads/arquivos/';
		$pastaPDF = '/public_html/uploads/arquivos/pdfs/'.get_id_loja().'/'.$userId.'/'.$data['data']['product_id']."/";
		$res = wp_mkdir_p($pastaPDF);
		$res = wp_mkdir_p($pastaUpload) === TRUE ? "Criou" : "Deu errado";
		if($res == 'Criou'){
				$caminhoFront = $pastaUpload.$data['data']['front'];
				$caminhoFrontCmyk = $pastaPDF.'/front_cmyk.bmp';
				$caminhoBack = $pastaUpload.$data['data']['back'];
				$caminhoBackCmyk = $pastaPDF.'/back_cmyk.bmp';
			if(isset($data['data']['acabamento'])){
				$caminhoAcab = $pastaUpload.$data['data']['acabamento'];
				$caminhoAcabCmyk = $pastaPDF.'/acab_cmyk.bmp';
				$temacabamento=1;
			}
		}else{
			exit("Erro de diretorio");
		}

		//pega perfil de cores
		$prfl = self::get_imagick_profiles();

		// converter arquivos para CMYK
		// O front sempre eh convertido
		$comando = "convert -units PixelsPerInch ". $caminhoFront ." -density 300 -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] ." ". $caminhoFrontCmyk ." 2>&1";
		exec($comando);
		// Thumb Front
		$comando = "convert -units PixelsPerInch ". $caminhoFront ." -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] . "  -resize 400x400 " . $pastaPDF.'/th-front-' . $savedName . '-x1a.png' ." 2>&1";
		exec($comando);
		
		
		//caso 1 (so front)
		if($data['data']['sides'] == 1 && $temacabamento == 0){
			//salvar em pdf
			exec('convert '.$caminhoFrontCmyk.' '.$pastaPDF.'/'.$savedName.'.pdf');
		}
		
		
		//caso 2 (so front e back sem acabamento)
		if($data['data']['sides'] == 2 && $temacabamento == 0){
			exec("convert -units PixelsPerInch ". $caminhoBack ." -density 300 -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] ." ". $caminhoBackCmyk ." 2>&1");
			// Thumb Back
    		exec("convert -units PixelsPerInch ". $caminhoBack ." -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] . "  -resize 400x400 " . $pastaPDF.'/th-back-' . $savedName . '-x1a.png' ." 2>&1");
			//salvar em pdf
			exec('convert '.$caminhoFrontCmyk.' '.$caminhoBackCmyk.' '.$pastaPDF.'/'.$savedName.'.pdf');
		}
		
		
		//caso 3 (front e acab)
		if($data['data']['sides'] == 1 && $temacabamento == 1){
    		exec("convert -units PixelsPerInch ". $caminhoAcab ." -density 300 -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] ." ". $caminhoAcabCmyk ." 2>&1");
			// Thumb Acab
    		exec("convert -units PixelsPerInch ". $caminhoAcab ." -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] . "  -resize 400x400 " . $pastaPDF.'/th-acab-' . $savedName . '-x1a.png' ." 2>&1");
			//salvar em pdf
			exec('convert '.$caminhoFrontCmyk.' '.$caminhoAcabCmyk.' '.$pastaPDF.'/'.$savedName.'.pdf');
		}


		//caso 4 (front back e acab)
		if($data['data']['sides'] == 2 && $temacabamento == 1){
			exec("convert -units PixelsPerInch ". $caminhoBack ." -density 300 -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] ." ". $caminhoBackCmyk ." 2>&1");
			// Thumb Back
    		exec("convert -units PixelsPerInch ". $caminhoBack ." -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] . "  -resize 400x400 " . $pastaPDF.'/th-back-' . $savedName . '-x1a.png' ." 2>&1");

    		exec("convert -units PixelsPerInch ". $caminhoAcab ." -density 300 -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] ." ". $caminhoAcabCmyk ." 2>&1");
			// Thumb Acab
    		exec("convert -units PixelsPerInch ". $caminhoAcab ." -profile ". $prfl['RGB'] ." -profile ". $prfl['CMYK'] . "  -resize 400x400 " . $pastaPDF.'/th-acab-' . $savedName . '-x1a.png' ." 2>&1");
			//salvar em pdf
			exec('convert '.$caminhoFrontCmyk.' '.$caminhoBackCmyk.' '.$caminhoAcabCmyk.' '.$pastaPDF.'/'.$savedName.'.pdf');
		}
		Log::debug("comando 1: ".$comando);
		$comando = '/usr/bin/pstill64 -v -M defaultall -m XPDFX=INTENTNAME -m XICCProfile=/public_html/uploads/ISOcoated_v2_eci.icc -m XPDFXVERSION=1A -o '. $pastaPDF.$savedName.'-x1a.pdf ' . $pastaPDF.$savedName.'.pdf';
		Log::debug("comando 2: ".$comando);
		exec($comando);


		$resposta = $savedName.'-x1a.pdf';
		
		//apaga bmp cmyk para não ocupar espaço no hd depois de convertido para pdf
		unlink($caminhoFrontCmyk);
		unlink($caminhoBackCmyk);
		unlink($caminhAcabCmyk);
		
		//unlink($caminhoFront);
		//unlink($caminhoBack);
		//unlink($caminhAcab);
		
		return $resposta; 	
	}

	public static function get_imagick_profiles(){
		$rgb = file_exists(__DIR__.'/color-profiles/sRGB-IEC61966-2.1.icc')? __DIR__.'/color-profiles/sRGB-IEC61966-2.1.icc' : exit("Erro ao buscar perfis de cor");
		$cmyk = file_exists(__DIR__.'/color-profiles/ISOcoated_v2_eci.icc')? __DIR__.'/color-profiles/ISOcoated_v2_eci.icc' : exit("Erro ao buscar perfis de cor");

		return array(
	    	'RGB'  => $rgb,
	    	'CMYK' => $cmyk
    	);
	}
}