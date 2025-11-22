<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post">
                        <h6 style="text-align: center; margin-top: 5%;">Alterar Palavra-Passe</h6>
                        <input class="form-control form-style" type="password" id="oldpass" name="oldpass" placeholder="Palavra-Passe atual"><br>
                        <input class="form-control form-style" type="password" id="newpass" name="newpass" placeholder="Nova Palavra-Passe"><br>
                        <input class="form-control form-style" type="password" id="newpass2" name="newpass2" placeholder="Repetir Palavra-Passe"><br>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="submit" id="salvar" name="salvar">Salvar alterações</button>
                </form>
                    <form method="post">
                        <button class="btn btn-primary" type="submit" id="logout" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap 5.2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- My Script -->
    <script src="script.js?1.0.2"></script>

</body>

</html>