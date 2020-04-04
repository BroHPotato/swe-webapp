window.axios = require("axios");

import { mount } from "@vue/test-utils";
import ChartManagement from "../resources/js/components/ChartManagement.vue";

describe("ChartManagement", () => {
    test("is a Vue instance", () => {
        const deviceId = 1;
        const sensorId = 1;
        const chart = mount(ChartManagement, {
            propsData: { deviceId, sensorId },
        });
        expect(chart.isVueInstance()).toBeTruthy();
    });
});
