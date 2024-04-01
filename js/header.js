const HeaderApp = {
    data() {
      return {
        PLANTA: '',
        tipo: '',
      };
    },
    created() {
      // Obtener los valores de $_SESSION o usar datos de prueba
      //this.nombre = 'Nombre de Usuario';
     // this.tipo = 'Tipo de Usuario';
    },
    template: `
    <div class ="col-12 cabecera d-flex justify-content-around" style="height: 10vh;">
      <div class="col-1 col-sm-1"><img class="img-fluid" style="min-height:50px; min-width:90px" src="img/logo_gonher.png"></div>
      <div class="col-9 col-sm-10 titulo fs-3 lh-1 text-center">EAD Tracking <br>System</div>
      <div class="col-2 col-sm-1"><img class="img-fluid" style="max-height:80px; min-width:50px;" src="img/opex.png"></div>
    </div>
    `,
  };
  
  const headerApp = Vue.createApp(HeaderApp);
  
  headerApp.mount('#header-app');