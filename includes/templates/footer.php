
    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>


        <p class="copyright">Todos los derechos Reservados <?php echo date('Y')?>  &copy;</p>
    </footer>

    <script src="/build/js/bundle.min.js"></script>
    <?php if(strpos($_SERVER['REQUEST_URI'], '/admin/') !== false): ?>
        <script src="/public/js/paginacion.js"></script>
    <?php endif; ?>
</body>
</html>