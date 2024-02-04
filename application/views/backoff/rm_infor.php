<?php
if($kodejob1!= $kodejob){
	$kodejob = $kodejob1;
}

$this->load->view('backoff/layout/_999/head');
$this->load->view('backoff/layout/_999/menu');
if ($rmmod!='') {
	$this->load->view('backoff/layout/_'.$kodejob.'/'.$rmmod);
    $this->load->view('backoff/layout/_999/foot');
    $this->load->view('backoff/layout/_'.$kodejob.'/addon-'.$rmmod);
} else {
//	if($idpeg!='2013.07.013'){
		redirect('markas/core1/?rmod=area1','refresh');
/*	} else {
		redirect('markas/core1/?rmod=area01&kodejob1=222','refresh');
	} */
    $this->load->view('backoff/layout/_999/foot');
    $this->load->view('backoff/layout/_'.$kodejob.'/addon-area1');
}
/*} else {
    redirect('/', 'refresh');
} */
?>
  </body>
</html>
