
<?$img_info = json_decode($contents['img_info'])?>
<title><?=$contents['title']?></title>
<meta property="og:url" content="<?=$this->config->item('base_url') . "/main/share?idx=" . $idx?>">
<meta property="og:title" content="<?=$contents['title']?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?=$this->config->item('base_url') . $img_info->img_path?>">
<meta property="og:description" content="<?=$contents['title']?>">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="<?=$this->config->item('base_url') . "/main/share?idx=" . $idx?>" />
<meta name="twitter:title" content="동아사이언스 디톡스" />
<meta name="twitter:description" content="<?=$contents['title']?>" />
<meta name="twitter:image" content="<?=$this->config->item('base_url') . $img_info->img_path?>" />
<?
if($idx != ''){
    redirect('/main?link_idx=' . $idx);

}
?>
