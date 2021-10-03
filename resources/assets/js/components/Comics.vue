<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-body">
                    <div class="position-absolute top-0 start-50 translate-middle-x">
                        <h2>Examenes</h2>
                        <button type="button" @click="abrirModal('examen','registrar')" class="btn btn-success">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    

                    <div class="card" style="width: 20rem;">
                        <img src="../../../../public/img/examen.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <tr v-for="objeto in arrayExamen" :key="objeto.id">
                                <h5 v-text="objeto.nombre" class="card-title"></h5>
                                <p v-text="objeto.descripcion" class="card-text"></p>
                                <div> 
                                    <i class="fas fa-hourglass-half" > Tiempo: <label for="" v-text="objeto.tiempo"></label> </i>
                                </div>
                                <div> 
                                    <i class="fas fa-list"> Cantidad de intentos permitidos: <label for="" v-text="objeto.intento"></label> </i>
                                </div>
                                <i class="fas fa-clipboard-list"> Total de preguntas: 3</i> <br><br><br>
                            </tr>
                            
                            <button type="button" class="btn btn-outline-success">Tablero</button>
                        </div>
                    </div>
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
                                <label class="form-control-label" for="text-input">Título del examen</label>
                                <div>
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Ingrese título">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                                <textarea class="form-control" v-model="descripcion" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="form-group row">
                                <label class="form-control-label" for="email-input">Tiempo en minutos</label>
                                <div>
                                    <input type="email" v-model="tiempo" class="form-control" placeholder="Ingrese tiempo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-control-label" for="email-input">Intentos permitidos</label>
                                <div>
                                    <input type="email" v-model="intento" class="form-control" placeholder="Ingrese número de intentos">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarExamen()">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </main>
</template>

<script>
    export default {
        data (){
            return {
                examen_id: 0,
                nombre : '',
                descripcion : '',
                tiempo : '',
                intento : '',
                arrayExamen : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
            }
        },
        computed:{
        },
        methods : {
            listarExamen (){
                let me=this;
                var url= '/examen';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayExamen = respuesta.examenes.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarExamen(){
                
                let me = this;

                axios.post( '/examen/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'tiempo': this.tiempo,
                    'intento': this.intento,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarExamen(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.tiempo='';
                this.intento='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "examen":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Examen';
                                this.nombre= '';
                                this.descripcion = '';
                                this.tiempo = '';
                                this.intento = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Examen';
                                this.tipoAccion=2;
                                this.examen_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                this.tiempo= data['tiempo'];
                                this.intento= data['intento'];
                                break;
                            }
                        }
                    }
                }
            },
        },
        mounted() {
            this.listarExamen();
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

    .modal-content1{
        width: 100% !important;
        position: absolute !important;
    }

    .modal-content1{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar1{
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
