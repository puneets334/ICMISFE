<style>

    .iFrameWrapper {
        position: relative;
        /*padding-bottom: 56.25%;*/
        padding-bottom: 70%;
        padding-top: 5px;
        height: 0;
    }
    .iFrameWrapper iframe {
        position: absolute;
        top: -8px;
        left: -8px;
        width: 102%;
        height: 102%;
        border: 0;
    }
</style>
<div class="iFrameWrapper">
    <iframe src="<?php echo $content_url;?>" allowfullscreen></iframe>
</div>