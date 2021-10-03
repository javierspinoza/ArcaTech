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
                    <i class="fa fa-align-justify"></i> Opcion Multiple
                    <button type="button" @click="abrirModal('multiple','registrar')" class="btn btn-success">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-select col-md-3" v-model="criterio">
                                    <option value="descripcion">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMultiple(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMultiple(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                    <th>Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="objeto in arrayMultile" :key="objeto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('multiple','actualizar',objeto)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" @click="eliminarMultiple(objeto)">
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
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Descripción</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" v-model="descripcion" id="exampleFormControlTextarea1" rows="3" placeholder="¿Qué es MYSQL?"></textarea>
                                </div>
                                <label class="col-md-1 form-control-label" for="text-input">Puntos</label>
                                <div class="col-md-2">
                                    <input type="number" v-model="puntos" class="form-control" placeholder="15" disabled>
                                </div>
                            </div>
                            <label class="form-control-label" for="text-input">Opciones</label>
                            <div class="input-group form-check form-switch">
                                <span class="input-group-text" id="basic-addon1">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" 
                                        type="checkbox" id="flexSwitchCheckChecked" v-model="respuesta" value="no" >
                                </span>
                                <input type="text" class="form-control" 
                                    placeholder="Un lenguaje de programación" aria-label="Username" 
                                    aria-describedby="basic-addon1" disabled
                                >
                            </div>
                            <label class="form-control-label" for="text-input">Opciones</label>
                            <div class="input-group form-check form-switch">
                                <span class="input-group-text" id="basic-addon1">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" 
                                    type="checkbox" id="flexSwitchCheckChecked" v-model="respuesta" value="no" >
                                </span>
                                <input type="text" class="form-control" 
                                    placeholder="Una técnica para escribir programas contables" aria-label="Username" 
                                    aria-describedby="basic-addon1" disabled
                                >
                            </div>
                            <label class="form-control-label" for="text-input">Opciones</label>
                            <div class="input-group form-check form-switch">
                                <span class="input-group-text" id="basic-addon1">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" 
                                    type="checkbox" id="flexSwitchCheckChecked"  v-model="respuesta" value="si">
                                </span>
                                <input type="text" class="form-control" 
                                    placeholder="Un sistema de gestión de bases de datos relacionales" aria-label="Username" 
                                    aria-describedby="basic-addon1" disabled
                                >
                            </div>
                            <label class="form-control-label" for="text-input">Opciones</label>
                            <div class="input-group form-check form-switch">
                                <span class="input-group-text" id="basic-addon1">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" 
                                    type="checkbox" id="flexSwitchCheckChecked" v-model="respuesta" value="no">
                                </span>
                                <input type="text" class="form-control"
                                    placeholder="Una Base de datos" aria-label="Username"
                                    aria-describedby="basic-addon1" disabled
                                >
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarMultiple()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarMultiple()">Actualizar</button>
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
                multiple_id: 0,
                puntos : 15,
                descripcion : '',
                respuesta : '', 
                arrayMultile : [],
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
            listarMultiple (page,buscar,criterio){
                let me=this;
                var url= '/multiple?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMultile = respuesta.multiples.data;
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
                me.listarMultiple(page,buscar,criterio);
            },
            registrarMultiple(){
                
                let me = this;

                axios.post( '/multiple/registrar',{
                    'puntos': this.puntos=15,
                    'descripcion': this.descripcion,
                    'respuesta': this.respuesta
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMultiple(1,'','descripcion');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarMultiple(){
                
                let me = this;

                axios.put( '/multiple/actualizar',{
                    'puntos': this.puntos=10,
                    'descripcion': this.descripcion,
                    'respuesta': this.respuesta,
                    'id': this.multiple_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarMultiple(1,'','descripcion');
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
                    case "multiple":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Opciones Multiples';
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
                                this.tituloModal='Actualizar Opciones Multiples';
                                this.tipoAccion=2;
                                this.multiple_id=data['id'];
                                this.puntos = data['puntos'];
                                this.respuesta = data['respuesta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            },
            eliminarMultiple(data = []) {
                Swal.fire({
                    title: '¿Estás seguro de eliminar?',
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
                        this.multiple_id = data["id"];
                        axios.post("/multiple/eliminar", {
                        id: this.multiple_id
                        })
                        .then(function(response) {
                            me.listarMultiple(1,'','descripcion');
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
            this.listarMultiple(1,this.buscar,this.criterio);
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
