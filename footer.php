<footer>
    <?php if(strstr($_SERVER['REQUEST_URI'],'top')==true):?>
        <div class="p-link__area">
            <span><a href="http://" target="_blank" rel="noopener noreferrer">利用規約</a></span>
            <span><a href="http://" target="_blank" rel="noopener noreferrer">プライバシーポリシー</a></span>
            <span><a href="http://" target="_blank" rel="noopener noreferrer">お問い合わせ</a></span>
            <span><a href="http://" target="_blank" rel="noopener noreferrer">運営会社</a></span>
            <span><a href="http://" target="_blank" rel="noopener noreferrer">採用情報</a></span>
        </div>
    <?php endif?>
    <div class="p-cover__wrap">
        <span>POPALES Inc.</span>
    </div>
    <?php wp_footer(); ?>
</footer>
</body>

</html>