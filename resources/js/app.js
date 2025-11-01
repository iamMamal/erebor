import '../css/app.css';
import './livewire-datepicker-datepicker';

import Chart from 'chart.js/auto';
import Swal from 'sweetalert2'
import ApexCharts from 'apexcharts';
import {NumberToWords} from "persian-tools2"

window.Chart = Chart;

window.Swal = Swal;

window.ApexCharts = ApexCharts;

import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
window.L = L;


import icon from 'leaflet/dist/images/marker-icon.png';
import iconShadow from 'leaflet/dist/images/marker-shadow.png';

L.Marker.prototype.options.icon = L.icon({
    iconUrl: icon,
    shadowUrl: iconShadow
});



function addCommas(num) {
    if (!num) return '';
    // اول عدد رو به عدد واقعی تبدیل کن
    let number = Number(num.toString().replace(/,/g, ''));
    if (isNaN(number)) return '';
    // سپس از toLocaleString برای اضافه کردن کاما استفاده کن
    return number.toLocaleString('en-US');
}

 window.testLog = function (value,callback) {
     // let raw = value.replace(/,/g, '');
     let result2 =addCommas(value)
     let result =value ? NumberToWords.convert(value) : '';

    if (typeof callback === 'function') {
        callback(result,result2);
    }
};


