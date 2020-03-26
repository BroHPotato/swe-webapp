window.axios = require("axios");

import { mount } from "@vue/test-utils";
import ChartManagement from "../resources/js/components/ChartManagement.vue";

describe("ChartManagement", () => {
    test("is a Vue instance", () => {
        const user = {};
        const device = {};
        const sensor = { sensorId: 1 };
        const chart = mount(ChartManagement, {
            propsData: { user, device, sensor },
        });
        expect(chart.isVueInstance()).toBeTruthy();
    });
});
