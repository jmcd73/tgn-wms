    <footer class="footer" id="footer">
    <div class="container">
        <hr>
    <?=$this->Html->link(
    $this->Html->image(
        Configure::read('footer.img'), [
            'alt' => Configure::read("contact.company"),
            'border' => '0',
            'class' => 'img-responsive footer-image']
    ), Configure::read('contact.company_url'), [
        'target' => '_blank',
        'rel'=> "noreferrer",
        'escape' => false,
        'class' => 'pull-right'
    ]
);
?>
</div>
</footer>
