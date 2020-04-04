const sensorsList = document.querySelector("#sensorsList");
const addSensor = document.querySelector("#addSensor");
const addDevice = document.querySelector("#addDevice");
const form = document.querySelector("#sensorForm");
let trashes = document.querySelectorAll(".delete");
let numSensor = 1;

const tableUsers = document.querySelector(".dataTableUsers");
$(document).ready(function () {
    $(tableUsers).dataTable({
        "scrollX": false,
        "pagingType": "full_numbers"
    });
});

addSensor.addEventListener("click", (e) => {
    e.preventDefault();
    const sensorIdValue = document.querySelector("#inputSensorId").value;
    const sensorTypeValue = document.querySelector("#inputSensorType").value;
    // aggiunta sensore al dispositivo
    if (sensorIdValue !== "" && sensorTypeValue !== "") {
        sensorsList.innerHTML += `
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">
                    <span class="fas fa-thermometer-half mx-1"></span>Sensore ${numSensor}
                </label>
                <label class="col-lg-2 col-form-label">
                    <span class="fas fa-tag mx-1"></span>Id sensore
                </label>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="Id sensore" value="${sensorIdValue}" name="sensorId">
                </div>
                <label class="col-lg-2 col-form-label">
                    <span class="fas fa-tape mx-1"></span>Tipologia
                </label>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="Tipo di sensore" value="${sensorTypeValue}" name="sensorType">
                </div>
                <div class="col-lg-1 col-form-label text-center d-none d-lg-block">
                    <span class="fas fa-trash text-danger delete"></span>
                </div>
                <div class="col-lg-1 d-lg-none my-1 text-center">
                    <button class="btn btn-danger btn-icon-split delete">
                        <span class="fas fa-trash icon text-white-50"></span>
                        <span class="text">Elimina sensore</span>
                    </button>
                </div>

            </div>
        `
        trashes = document.querySelectorAll(".delete");
        // eliminazione sensore aggiunto
        trashes.forEach((trash) => {
            trash.addEventListener("click", (e) => {
                e.preventDefault();
                trash.parentElement.parentElement.remove();
            });
        });
        numSensor++;
        form.reset();
    } else {
        alert("Id e tipo di sensore necessitano di un valore");
    }
});

// aggiunta dispositivo
addDevice.addEventListener("click", (e) => {
    const deviceIdValue = document.querySelector("#inputDeviceId").value;
    const deviceNameValue = document.querySelector("#inputDeviceName").value;
    if (deviceIdValue !== "" && deviceNameValue !== "") {
        alert("Dispositivo aggiunto correttamente");
    } else {
        e.preventDefault();
        alert("Id e nome del dispositivo necessitano di un valore");
    }
});
