<?php
//By Shunxian Wu
//orchid.x@outlook.com

function create_node($root,$name,$attr,$parent = null) {
	$node = $root->createElement($name);
	foreach ($attr as $k => $v) $node->setAttribute($k,$v);
	if ($parent) $parent->appendChild($node);
	return $node;
}

function create_speak_node($root,$lang,$parent = null) {
	return create_node($root,'speak',[
		'version'=>'1.0',
		'xmlns'=>'http://www.w3.org/2001/10/synthesis',
		'xmlns:mstts'=>'https://www.w3.org/2001/mstts',
		'xml:lang'=>$lang
	],$parent);
}

function create_voice_node($root,$data,$parent = null) {
	if (gettype($data) === 'string') {
		return create_node($root,'voice',[
			'name'=>$data
		],$parent);
	} else {
		$voice = create_node($root,'voice',[
			'name'=>$data[0]
		],$parent)	;
		$nps = ['0' =>$voice];
		$np = $nps['0'];
		for ($i=1; $i<count($data); $i++) {
			switch (gettype($data[$i])) {
				case 'string':
					create_text_node($root,$data[$i],$np);
					break;
				case 'array':
					foreach ($data[$i] as $k =>$v) $np = create_node($root,$k,$v,$np);
					break;
				case 'integer':
					if (isset($nps['' . $data[$i]])) $np = $nps['' . $data[$i]];
					else $nps['' . $data[$i]] = $np;
			}
		}
		return $voice;
	}
}

function create_text_node($root,$text,$parent) {
	$node = $root->createTextNode($text);
	if ($parent) $parent->appendChild($node);
	return $node;
}

function build_mstts_xml($voices) {
	if (!$voices) return '';
	$xml = new DOMDocument('1.0','UTF-8');
	$speak = create_speak_node($xml,'zh-CN',$xml);
	switch (gettype($voices)) {
		case 'string':
			create_text_node($xml,$voices,create_voice_node($xml,'zh-CN-XiaomoNeural',$speak));
			break;
		case 'array':
			if (count($voices) < 2) return '';
			if (gettype($voices[0]) === 'string') create_voice_node($xml,$voices,$speak);
			elseif (gettype($voices[0]) === 'array') {
				foreach ($voices as $v) create_voice_node($xml,$v,$speak);
			}
			break;
		default:
			return '';
	}
	return $xml->saveXML();
}

?>