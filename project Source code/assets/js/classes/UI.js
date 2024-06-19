import { eliminarCita, cargarEdicion } from "../funciones.js"
import { contenedorCitas } from "../selectores.js"

class UI {
    mostrarAlerta(mensaje, tipo) {
        //div creation
        const divMensaje = document.createElement('div');
        divMensaje.classList.add('alert', 'text-center', 'd-block', 'col-12');

        //Message type validation
        if (tipo === 'error') {
            divMensaje.classList.add('alert-danger');
        } else {
            divMensaje.classList.add('alert-success');
        }

        //Text is added
        divMensaje.textContent = mensaje;

        //Add to DOM
        document.querySelector('#contenido').insertBefore(divMensaje, document.querySelector('.agregar-cita'));

        //Remove alert after 5 seconds
        setTimeout(() => {
            divMensaje.remove();
        }, 5000);
    }

    mostrarCitas({ citas }) {
        this.limpiarHTML();

        citas.forEach(cita => {
            const { mascota, propietario, telefono, fecha, hora, sintomas, id } = cita;

            const divCita = document.createElement('div');
            divCita.classList.add('cita', 'p-3');
            divCita.dataset.id = id;

            //Scripting quote elements
            const mascotaParrafo = document.createElement('h2');
            mascotaParrafo.classList.add('card-title', 'font-weight-bolder');
            mascotaParrafo.textContent = mascota;

            // const mascotaParrafo = document.createElement('p');
            // propParrafo.innerHTML = `
            //     <span class="font-weight-bolder">First Name: </span>${mascota}
            // `;

            const propParrafo = document.createElement('p');
            propParrafo.innerHTML = `
                <span class="font-weight-bolder">Last Name: </span>${propietario}
            `;

            const telParrafo = document.createElement('p');
            telParrafo.innerHTML = `
                <span class="font-weight-bolder">T.P Number: </span>${telefono}
            `;

            const fechaParrafo = document.createElement('p');
            fechaParrafo.innerHTML = `
                <span class="font-weight-bolder">Date: </span>${fecha}
            `;

            const horaParrafo = document.createElement('p');
            horaParrafo.innerHTML = `
                <span class="font-weight-bolder">Time: </span>${hora}
            `;

            const sintomasParrafo = document.createElement('p');
            sintomasParrafo.innerHTML = `
                <span class="font-weight-bolder">Comments: </span>${sintomas}
            `;


            //Add delete button
            const btnEliminar = document.createElement('button');
            btnEliminar.onclick = () => eliminarCita(id); //adds delete option
            btnEliminar.classList.add('btn', 'btn-danger', 'mr-2');
            btnEliminar.innerHTML = 'Delete <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';

            //Edit button

            const btnEditar = document.createElement('button');
            btnEditar.onclick = () => cargarEdicion(cita);

            btnEditar.classList.add('btn', 'btn-info');
            btnEditar.innerHTML = 'Edit <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>';

            //pay button
            // const btnpay = document.createElement('button');
            // btnpay.onclick = () => "";

            // btnpay.classList.add('btn', 'btn-info');
            // btnpay.innerHTML = 'Pay <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>';

            //Add the paragraphs to the Quote div
            divCita.appendChild(mascotaParrafo);
            divCita.appendChild(propParrafo);
            divCita.appendChild(telParrafo);
            divCita.appendChild(fechaParrafo);
            divCita.appendChild(horaParrafo);
            divCita.appendChild(sintomasParrafo);
            divCita.appendChild(btnEliminar);
            divCita.appendChild(btnEditar);

            //Add citations to HTML
            contenedorCitas.appendChild(divCita);

        });
    }

    limpiarHTML() {
        while (contenedorCitas.firstChild) {
            contenedorCitas.removeChild(contenedorCitas.firstChild);
        }
    }
}

export default UI;