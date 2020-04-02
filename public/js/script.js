const sensorsList = document.querySelector("#sensorsList");
const addSensor = document.querySelector("#addSensor");
const addDevice = document.querySelector("#addDevice");
const form = document.querySelector("#sensorForm");
let numSensor = 1;

addSensor.addEventListener("click", (e) => {
    e.preventDefault();
    const sensorIdValue = document.querySelector("#inputSensorId").value;
    const sensorTypeValue = document.querySelector("#inputSensorType").value;
    if (sensorIdValue !== "" && sensorTypeValue !== "") {
        sensorsList.innerHTML += `
            <div class="form-group row">
                <label class="col-lg-4 col-form-label"><span class="fas fa-thermometer-half mx-1"></span>Sensore ${numSensor}</label>
                <label class="col-lg-2 col-form-label"><span class="fas fa-tag mx-1"></span>Id sensore</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Id sensore" value="${sensorIdValue}" name="sensorId">
                    </div>
                <label class="col-lg-2 col-form-label"><span class="fas fa-tape mx-1"></span>Tipologia</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Tipo di sensore" value="${sensorTypeValue}" name="sensorType">
                    </div>
            </div>
        `
        numSensor++;
        form.reset();
    } else {
        alert("Id e tipo di sensore necessitano di un valore");
    }
});

addDevice.addEventListener("click", (e) => {
    const deviceIdValue = document.querySelector("#inputDeviceId").value;
    const deviceNameValue = document.querySelector("#inputDeviceName").value;
    if (deviceIdValue !== "" && deviceNameValue !== "") {
        alert("Dispositivo aggiunto correttamente");
    } else {
        e.preventDefault();
        alert("Id e neme del dispositivo necessitano di un valore");
    }
});
