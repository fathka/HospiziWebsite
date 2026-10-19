

<div class="modal fade" id="modalTambahPasien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg border-0 shadow-lg">
        <div class="modal-content border-0" style="border-radius: 15px; overflow: hidden;">
            
            <div class="modal-header border-0 p-4" style="background: linear-gradient(45deg, #73CCBF, #5FB6AA);">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-user-plus mr-2"></i> Form Tambah Pasien Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?= base_url('ahli-gizi/simpan-pasien') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body bg-light p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">NOMOR RM</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-id-card text-muted"></i></span>
                                    </div>
                                    <input type="text" name="no_rm" class="form-control border-left-0" placeholder="RM001" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">NAMA LENGKAP</label>
                                <input type="text" name="nama_lengkap" class="form-control shadow-sm" placeholder="Masukkan nama pasien" required style="border-radius: 8px;">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold text-dark">TANGGAL LAHIR</label>
                                        <input type="date" name="tanggal_lahir" class="form-control shadow-sm" style="border-radius: 8px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold text-dark">TANGGAL MASUK</label>
                                        <input type="date" name="tanggal_masuk" class="form-control shadow-sm" style="border-radius: 8px;">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">BANGSAL / KAMAR</label>
                                <input type="text" name="bangsal" class="form-control shadow-sm" placeholder="Contoh: Melati - Bed 01" style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">KATEGORI PENYAKIT</label>
                                <select name="jenis_penyakit" class="form-control shadow-sm" style="border-radius: 8px;">
                                    <option value="">-- Kategori Penyakit --</option>
                                    <option value="Tifus">Kronis</option>
                                    <option value="Diabetes">Non Kronis</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">JENIS DIET</label>
                                <input type="text" name="status_diet" class="form-control shadow-sm" placeholder="Contoh: Diet Rendah Garam" style="border-radius: 8px;">
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">ALERGI</label>
                                <input type="text" name="alergi_pasien" class="form-control shadow-sm" placeholder="Sebutkan alergi jika ada" style="border-radius: 8px;">
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-dark">DIAGNOSA MEDIS</label>
                                <textarea name="diagnosa" class="form-control shadow-sm" rows="3" placeholder="Input diagnosa awal..." style="border-radius: 8px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white border-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color: #73CCBF; border: none;">
                        <i class="fas fa-save mr-1"></i> Simpan Data Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>