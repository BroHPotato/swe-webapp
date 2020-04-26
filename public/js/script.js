const sensorsList = document.querySelector("#sensorsList");
const addSensor = document.querySelector("#addSensor");
const addDevice = document.querySelector("#addDevice");
const form = document.querySelector("#sensorForm");
let trashes = document.querySelectorAll(".delete");

const tables = document.querySelectorAll(".table");

if (tables !== undefined) {
    tables.forEach((table) => {
        $(document).ready(function () {
            $(table).dataTable({
                sDom:
                    '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12 mb-0 mt-2"p>>',
                scrollX: false,
                autoWidth: true,
                pageLength: 15,
                ordering: false,
                lengthChange: false,
                pagingType: "simple_numbers",
                searching: false,
                language: {
                    url:
                        "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Italian.json",
                    // "url": "dataTables.italian.lang"
                },
            });
        });
    });
}

if (addSensor !== null) {
    addSensor.addEventListener("click", (e) => {
        e.preventDefault();
        const sensorIdValue = document.querySelector("#inputSensorId").value;
        const hasSensor =
            sensorsList.querySelector("#sensore" + sensorIdValue) != null;
        if (!hasSensor) {
            const sensorTypeValue = document.querySelector("#inputSensorType")
                .value;
            // aggiunta sensore al dispositivo
            if (sensorIdValue !== "" && sensorTypeValue !== "") {
                sensorsList.innerHTML += `
            <div id="sensore${sensorIdValue}" class="form-group row">
                <label class="col-lg-3 col-form-label">
                    <span class="fas fa-thermometer-half mx-1"></span>Sensore ${sensorIdValue}
                </label>
                <label class="col-lg-2 col-form-label">
                    <span class="fas fa-tag mx-1"></span>Id sensore
                </label>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="Id sensore" readonly="readonly" value="${sensorIdValue}" name="sensorId">
                </div>
                <label class="col-lg-2 col-form-label">
                    <span class="fas fa-tape mx-1"></span>Tipologia
                </label>
                <div class="col-lg-2">
                    <input type="text" class="form-control" placeholder="Tipo di sensore" readonly="readonly" value="${sensorTypeValue}" name="sensorType">
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
        `;

                trashes = document.querySelectorAll(".delete");
                // eliminazione sensore aggiunto
                trashes.forEach((trash) => {
                    trash.addEventListener("click", (e) => {
                        e.preventDefault();
                        trash.parentElement.parentElement.remove();
                    });
                });
                form.reset();
            } else {
                alert("Id e tipo di sensore necessitano di un valore");
            }
        } else {
            alert("L'Id del sensore deve essere univoco");
        }
    });
}
// aggiunta dispositivo
if (addDevice !== null) {
    addDevice.addEventListener("click", (e) => {
        const deviceIdValue = document.querySelector("#inputDeviceId").value;
        const deviceNameValue = document.querySelector("#inputDeviceName")
            .value;
        if (deviceIdValue !== "" && deviceNameValue !== "") {
            alert("Dispositivo aggiunto correttamente");
        } else {
            e.preventDefault();
            alert("Id e nome del dispositivo necessitano di un valore");
        }
    });
}

trashes = document.querySelectorAll(".delete");
// eliminazione sensore aggiunto
trashes.forEach((trash) => {
    trash.addEventListener("click", (e) => {
        e.preventDefault();
        trash.parentElement.parentElement.remove();
    });
});
