<div class="container mt-5">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addGambar"><i
                    class="fas fa-upload"></i> Convert gambar</a>
            <table class="table" id="datatablesSimple">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">file original</th>
                        <th scope="col">View</th>
                        <th scope="col">file convert</th>
                        <th scope="col">View</th>
                        <th scope="col">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    <?php foreach($convert as $c ) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $c['nama']; ?></td>
                        <td><?= $c['original']; ?></td>
                        <td><a class="btn btn-sm btn-primary" target="_blank"
                                href="<?= base_url('assets/img/original/'.$c['original']); ?>">View</a></td>
                        <td><?= $c['webp']; ?></td>
                        <td><a class="btn btn-sm btn-warning" target="_blank"
                                href="<?= base_url('assets/img/webp/'.$c['webp']); ?>">View</a></td>
                        <td><a class="btn btn-sm btn-danger"
                                href="<?= base_url('ProsesController/hapus/'.$c['id']); ?>"><i
                                    class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="col mt-3">
                <form>
                    <input id="x" type="hidden" name="content">
                    <trix-editor input="x"></trix-editor>
                    <button type="submit">save</button>
                </form>
            </div>
        </div>
    </div>
</div>