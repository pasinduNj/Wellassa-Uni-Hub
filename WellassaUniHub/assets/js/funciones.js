import Citas from "./classes/Citas.js"
import UI from "./classes/UI.js";

import { mascotaInput, propietarioInput, telefonoInput, fechaInput, horaInput, sintomasInput, formulario } from "./selectores.js";


const administrarCitas = new Citas();
const ui = new UI();

let editando = false;

// main object
const citaObj = {
    mascota: '',
    propietario: '',
    telefono: '',
    fecha: '',
    hora: '',
    sintomas: ''
}

// Add data to the appointment object 
export function datosCita(e) {
    // Write about the object
    citaObj[e.target.name] = e.target.value;
}

export function nuevaCita(e) {
    e.preventDefault();

    // Extract info from the object
    const { mascota, propietario, telefono, fecha, hora, sintomas } = citaObj;

    // Validacion

    if (mascota === '' || propietario === '' || telefono === '' || fecha === '' || hora === '' || sintomas === '') {
        ui.mostrarAlerta('Field Empty', 'error');
        return;
    }

    if (editando) {
        // We are editing
        administrarCitas.editarCita({ ...citaObj });

        ui.mostrarAlerta('Saved Successfully');

        formulario.querySelector('button[type="submit"]').textContent = 'Create Appointment';

        editando = false;

    } else {
        // New Registering

        //Generate a unique ID
        citaObj.id = Date.now();

        //Add the new appointment
        administrarCitas.agregarCita({ ...citaObj });

        //Show message that everything is fine...
        ui.mostrarAlerta('Added successfully')
    }

    //Show HTML Citations
    ui.mostrarCitas(administrarCitas);

    //Reset form and object
    reiniciarObjeto();
    formulario.reset();

}

//Empties the object so that it is correctly loaded into the array
export function reiniciarObjeto() {
    citaObj.mascota = '';
    citaObj.propietario = '';
    citaObj.telefono = '';
    citaObj.fecha = '';
    citaObj.hora = '';
    citaObj.sintomas = '';
}

// Elimina cita
export function eliminarCita(id) {
    administrarCitas.eliminarCita(id);

    ui.mostrarAlerta('Appointment was successfully deleted');

    ui.mostrarCitas(administrarCitas);
}

// Edita cita
export function cargarEdicion(cita) {
    const { mascota, propietario, telefono, fecha, hora, sintomas, id } = cita;

    //Reset the object
    citaObj.mascota = mascota;
    citaObj.propietario = propietario;
    citaObj.telefono = telefono;
    citaObj.fecha = fecha
    citaObj.hora = hora;
    citaObj.sintomas = sintomas;
    citaObj.id = id;

    //Fill out the entries
    mascotaInput.value = mascota;
    propietarioInput.value = propietario;
    telefonoInput.value = telefono;
    fechaInput.value = fecha;
    horaInput.value = hora;
    sintomasInput.value = sintomas;

    //Change button text
    formulario.querySelector('button[type="submit"]').textContent = 'Save Changes';

    editando = true;
}