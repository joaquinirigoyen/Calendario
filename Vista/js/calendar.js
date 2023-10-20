document.addEventListener("DOMContentLoaded", function(){

    

  $('.clockpicker').clockpicker();

  let calendario1 = new FullCalendar.Calendar(document.getElementById('Calendario1'),{
    droppable: true,
    locale:'es',
    height: 850,
    headerToolbar:{
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    editable: true,
    events: 'accionEventos.php',
    /* events: 'datoseventos.php?accion=listar', */
    dateClick: function(info){
      limpiarFormulario();
      $('#BotonAgregar').show();
      $('#BotonModificar').hide();
      $('#BotonBorrar').hide();

      if (info.allDay) {
        $('#FechaInicio').val(info.dateStr);
        $('#FechaFin').val(info.dateStr);
      }else{
        let fechaHora = info.dateStr.split("T");
        $('#FechaInicio').val(fechaHora[0]);
        $('#FechaFin').val(fechaHora[0]);
        $('#HoraInicio').val(fechaHora[1].substring(0,5));
      }
      $("#FormularioEventos").modal('show');
    },
    eventClick: function(info) {
      $('#BotonAgregar').hide();
      $('#BotonModificar').show();
      $('#BotonBorrar').show();
      $('#Id').val(info.event.id);
      $('#Titulo').val(info.event.title);
      $('#Descripcion').val(info.event.extendedProps.descripcion);
      $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
      $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
      $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
      $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
      $('#ColorFondo').val(info.event.backgroundColor);
      $('#ColorTexto').val(info.event.textColor);
      $("#FormularioEventos").modal('show');
    },
    eventResize: function(info){
      $('#Id').val(info.event.id);
      $('#Titulo').val(info.event.title);
      $('#Descripcion').val(info.event.extendedProps.descripcion);
      $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
      $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
      $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
      $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
      $('#ColorFondo').val(info.event.backgroundColor);
      $('#ColorTexto').val(info.event.textColor);
      let registro = recuperarDatosFormulario();
      modificarRegistro(registro);
    },
    eventDrop: function(info){
      $('#Id').val(info.event.id);
      $('#Titulo').val(info.event.title);
      $('#Descripcion').val(info.event.extendedProps.descripcion);
      $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
      $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
      $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
      $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
      $('#ColorFondo').val(info.event.backgroundColor);
      $('#ColorTexto').val(info.event.textColor);
      let registro = recuperarDatosFormulario();
      modificarRegistro(registro);
    },
   
  });

  calendario1.render();

  //Eventos de botones de la aplicacion
  $('#BotonAgregar').click(function(){
    let registro = recuperarDatosFormulario();
    agregarRegistro(registro);
    $('#FormularioEventos').modal('hide');
  });

  $('#BotonModificar').click(function(){
    let registro = recuperarDatosFormulario();
    modificarRegistro(registro);
    $('#FormularioEventos').modal('hide');
  });

  $('#BotonBorrar').click(function(){
    let registro = recuperarDatosFormulario();
    borrarRegistro(registro);
    $('#FormularioEventos').modal('hide');
  });

  


  //funciones para comunicarse con el servidor
  function agregarRegistro(registro) {
    $.ajax({
      type: 'POST',
      /* url: 'datoseventos.php?accion=agregar', */
      url: 'accionEventosAgregar.php',
      data: registro,
      success: function(msg){
        calendario1.refetchEvents();
      },
      error: function(error) {
        alert("Hubo un error al agregar el evento: " + error);
      }
    });
  }

  function modificarRegistro(registro){
    $.ajax({
      type: 'POST',
      /* url: 'datoseventos.php?accion=modificar', */
      url: 'accionEventosModificar.php',
      data: registro,
      success: function(msg){
        calendario1.refetchEvents();
      },
      error: function(error) {
        alert("Hubo un error al modificar el evento: " + error);
      }
    });
  }

  function borrarRegistro(registro){
    $.ajax({
      type: 'POST',
      url: 'accionEventosBorrar.php',
      /* url: 'datoseventos.php?accion=borrar', */
      data: registro,
      success: function(msg){
        calendario1.refetchEvents();
      },
      error: function(error) {
        alert("Hubo un error al borrar el evento: " + error);
      }
    });
  }

  


  //funciones que interactuan con el FormularioEventos

  function limpiarFormulario(){
    $('#Id').val('');
    $('#Titulo').val('');
    $('#Descripcion').val('');
    $('#FechaFin').val('');
    $('#FechaInicio').val('');
    $('#HoraInicio').val('');
    $('#HoraFin').val('');
    $('#ColorFondo').val('#3788D8');
    $('#ColorTexto').val('#ffffff');
  }

  function recuperarDatosFormulario(){
    let registro = {
      id: $('#Id').val(),
      title: $('#Titulo').val(),
      descripcion: $('#Descripcion').val(),
      start: $('#FechaInicio').val() + ' ' + $('#HoraInicio').val(),
      end: $('#FechaFin').val() + ' ' + $('#HoraFin').val(),
      backgroundColor: $('#ColorFondo').val(),
      textColor: $('#ColorTexto').val()
    }
    return registro;
  }

});