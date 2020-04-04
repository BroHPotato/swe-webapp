window.axios = require("axios");

import { mount } from "@vue/test-utils";
import ChartManagement from "../resources/js/components/ChartManagement.vue";

describe("ChartManagement", () => {
    test("is a Vue instance", () => {
        const sensor2 =
            '{"type":"stick","realSensorId":1,"device":1,"sensorId":1}';
        const sensor1 =
            '{"type":"stick","realSensorId":1,"device":1,"sensorId":1}';
        const chart = mount(ChartManagement, {
            propsData: { sensor2, sensor1 },
        });
        expect(chart.isVueInstance()).toBeTruthy();
    });
});
