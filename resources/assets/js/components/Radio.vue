<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Falso o Verdadero
                    <button type="button" @click="abrirModal('radio','registrar')" class="btn btn-success">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-select col-md-3" v-model="criterio">
                                    <option value="descripcion">Descripción</option>
                                    <option value="puntos">Puntos</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarRadio(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarRadio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Descripción</th>
                                    <th>Puntos</th>
                                    <th>Falso o Verdadero</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="objeto in arrayRadio" :key="objeto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('radio','actualizar',objeto)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" @click="eliminarRadio(objeto)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                    <td v-text="objeto.descripcion"></td>
                                    <td v-text="objeto.puntos"></td>
                                    <td v-text="objeto.respuesta"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="exampleModalCenter" :class="{'mostrar' : modal}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="respuesta" value="verdadero" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Verdadero
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="respuesta" value="falso" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Falso
                                </label>
                            </div> <br>
                            <!-- <div class="col-md-4">
                                <select v-model="respuesta" class="form-control">
                                    <option value="verdadero">Verdadero</option>
                                    <option value="falso">Falso</option>
                                </select>
                            </div> -->
                            <div class="form-group row">
                                <label class="form-control-label" for="text-input">Puntos</label>
                                <div>
                                    <input type="text" v-model="puntos" class="form-control" placeholder="10" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                                <textarea class="form-control" v-model="descripcion" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRadio()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRadio()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data (){
            return {
                radio_id: 0,
                puntos : 0,
                descripcion : '',
                respuesta : '',
                arrayRadio : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'descripcion',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarRadio (page,buscar,criterio){
                let me=this;
                var url= '/radio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRadio = respuesta.radios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRadio(page,buscar,criterio);
            },
            registrarRadio(){
                
                let me = this;

                axios.post( '/radio/registrar',{
                    'puntos': this.puntos=10,
                    'descripcion': this.descripcion,
                    'respuesta': this.respuesta
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRadio(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarRadio(){
                
                let me = this;

                axios.put( '/radio/actualizar',{
                    'puntos': this.puntos=10,
                    'descripcion': this.descripcion,
                    'respuesta': this.respuesta,
                    'id': this.radio_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRadio(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.puntos='';
                this.descripcion='';
                this.respuesta='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "radio":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Respuesta';
                                this.puntos= '';
                                this.descripcion = '';
                                this.respuesta = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Respuesta';
                                this.tipoAccion=2;
                                this.radio_id=data['id'];
                                this.puntos = data['puntos'];
                                this.respuesta = data['respuesta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            },
            eliminarRadio(data = []) {
                Swal.fire({
                    title: '¿Estás seguro de eliminar?' + data["puntos"],
                    text: "No podras revertir estos cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borra este dato!',
                    cancelButtonText: 'No, Cancelalo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        this.radio_id = data["id"];
                        axios.post("/radio/eliminar", {
                        id: this.radio_id
                        })
                        .then(function(response) {
                            me.listarRadio(1,'','descripcion');
                        })
                        .catch(function(error) {
                        console.log(error);
                        });

                        Swal.fire(
                        'Eliminado!',
                        'Dato borrado correctamente.',
                        'success'
                        )
                    }
                })
            },
            mensaje(tipo, crud) {
                Swal.fire(
                    tipo, 'El registro se ' + crud + 
                    ' con éxito. ',
                    'success'
                )
            },
        },
        mounted() {
            this.listarRadio(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
