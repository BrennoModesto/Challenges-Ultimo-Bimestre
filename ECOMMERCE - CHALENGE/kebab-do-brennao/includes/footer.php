<?php // includes/footer.php ?>
</main>
<footer class="footer-kebab mt-5">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-5">
                <h5 class="brand">🥙 Kebab do Brennão</h5>
                <p class="mb-0">Sabores do Oriente Médio preparados na brasa, com receitas de família e ingredientes frescos.</p>
            </div>
            <div class="col-md-3">
                <h6>Links</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?= e(base_url()) ?>/index.php">Cardápio</a></li>
                    <li><a href="<?= e(base_url()) ?>/carrinho.php">Carrinho</a></li>
                    <li><a href="<?= e(base_url()) ?>/login.php">Minha conta</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Autor</h6>
                <p class="mb-0">Brenno Eduardo Modesto Silva<br>
                    <a href="mailto:brennoeduardomodestosilva@gmail.com">brennoeduardomodestosilva@gmail.com</a><br>
                    <a href="https://github.com/BrennoModesto" target="_blank" rel="noopener noreferrer">github.com/BrennoModesto</a>
                </p>
            </div>
        </div>
        <hr>
        <p class="text-center small mb-0">&copy; <?= date('Y') ?> Kebab do Brennão — Brenno Eduardo Modesto Silva. Projeto acadêmico, Técnico em Informática — Senac Nações Unidas.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(base_url()) ?>/assets/js/script.js"></script>
</body>
</html>
