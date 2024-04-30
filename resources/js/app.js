import "./bootstrap";
import "flowbite";
import $ from "jquery";
import Alpine from "alpinejs";
import mask from "@alpinejs/mask";

Alpine.plugin(mask);

window.$ = $;

const formatCurrency = (event) => {
    let input = event.target;
    let value = input.value.replace(/\D/g, ""); // Remove não dígitos
    value = (value / 100).toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
    input.value = value;
};

window.helpers = { formatCurrency };
