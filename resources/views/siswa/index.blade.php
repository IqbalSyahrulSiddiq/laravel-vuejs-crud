<!DOCTYPE html>
<html>

<head>
    <title>Laravel Vuejs</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container" id="appVue">
        <div class="row">
            <div class="col-md-12">
            <br>
            <br>
            <button class="btn btn-lg btn-primary" v-on:click.prevent="tambahData">Tambah Data</button>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="item in data_siswa">
                                <tr>
                                    <td>
                                        <img v-bind:src="item . photo" alt="" style="width: 100px">
                                    </td>
                                    <td>@{{ item . nama }}</td>
                                    <td>@{{ item . alamat }}</td>
                                    <td>@{{ item . created_at }}</td>
                                    <td>@{{ item . updated_at }}</td>
                                    <td>
                                        <button v-on:click.prevent="editData(item.id)"
                                            class="btn btn-xs btn-warning">Edit Data</button>
                                        <button v-on:click.prevent="hapusData(item.id)" class="btn btn-xs btn-danger">Hapus
                                            Data</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal --> 

        <div class="modal fade" id="modalTambahData" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Warning</h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama</label>
                                <input v-model="nama" type="text" class="form-control" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <textarea v-model="alamat" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Photo</label>
                                <input v-on:change="inputFile($event)" type="file" class="form-control">
                                <br>
                                <div>
                                    <img v-if="url_preview" v-bind:src="url_preview" alt="" style="width: 100%">
                                </div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button v-on:click.prevent="storeSiswa" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    </div>


    <!-- Link embed vuejs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var vue = new Vue({
            el: "#appVue",
            data: {
                data_siswa: [],
                nama: null,
                alamat:null,
                id_edit: null,
                file:'',
                url_preview:''
            },
            mounted() {
                this.getData();
            },
            methods: {
                //get data from table
                getData: function() {
                var url = "{{ url('/siswa/list') }}";
                axios.get(url)
                    .then(resp => {
                        //console.log(resp);
                        this.data_siswa = resp.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                    })
                 },

                //Show modal form add data
                 tambahData: function() {
                    $('#modalTambahData').modal('show');
                },

                //store data to database
                storeSiswa: function() {
                    var form_data = new FormData();
                    form_data.append("nama", this.nama);
                    form_data.append("alamat", this.alamat);
                    form_data.append("id_edit", this.id_edit);
                    form_data.append("file", this.file);

                    var url = "{{ url('/siswa/post') }}";
                    axios.post(url, form_data)
                        .then(resp => {
                            $('#modalTambahData').modal('hide');
                            alert('Success');
                            this.nama = null;
                            this.alamat = null;
                            this.id_edit = null;
                            this.url_preview = null;
                            this.file = null;
                            this.getData();
                        })
                        .catch(err => {
                            alert('error');
                            console.log(err);
                        })
                },

                //edit data
                editData: function(id) {
                    this.id_edit = id;
                    var url = "{{ url('/siswa/detail') }}" + '/' + id;
                    axios.get(url)
                        .then(resp => {
                            var siswa = resp.data;
                            this.nama = siswa.nama;
                            this.alamat = siswa.alamat;
                            this.tambahData();
                        })
                        .catch(err => {
                            alert('error');
                            console.log(err);
                        })
                        .finally(() => {
                        })
                },

                //hapus data
                hapusData: function(id) {
                    var url = "{{ url('/siswa/delete') }}" + '/' + id;
                    axios.get(url)
                        .then(resp => {
                            console.log(resp);
                            this.getData();
                        })
                        .catch(err => {
                            alert('error');
                            console.log(err);
                        })
                        .finally(() => {
                        })
                },

                //Upload foto 
                inputFile: function(event) {
                    this.file = event.target.files[0];
                },

                //Preview data 
                inputFile: function(event) {
                    this.file = event.target.files[0];
                    this.url_preview = URL.createObjectURL(this.file);
                }

            

            }
        })
    </script>
</body>
</html>