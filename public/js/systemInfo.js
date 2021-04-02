/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

let counter = 0;
let intervalMs = 2000;
let timeout = null;

function updateSystemLoad() {
    const maxHeight = 80;

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                counter++;
                if (counter > 300) {
                    intervalMs = 5000;
                } else if (counter > 150) {
                    intervalMs = 3000;
                }

                let loadResponse = JSON.parse(this.responseText);
                let height = Math.floor((loadResponse['now'] / loadResponse['factor']) * maxHeight);
                let marginTop = maxHeight - height;

                let container = document.getElementById('system_info_load_graph_inner');
                container.insertAdjacentHTML(
                    'beforeend',
                    '<div id="load_bar_' + counter + '" class="load_bar" style="height: ' + height + 'px; margin-top: ' + marginTop + 'px;"></div>'
                );

                // update load text values
                let last1Minute = document.getElementById('system_load_last_1_minute');
                last1Minute.innerText = loadResponse['now'];
                let last5Minutes = document.getElementById('system_load_last_5_minutes');
                last5Minutes.innerText = loadResponse['5min'];
                let last15Minutes = document.getElementById('system_load_last_15_minutes');
                last15Minutes.innerText = loadResponse['15min'];

                if (counter > 300) {
                    let barElement = document.getElementById('load_bar_' + (counter - 300));
                    if (barElement !== null) {
                        barElement.remove();
                    }
                }

                // start timeout again
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    updateSystemLoad();
                }, intervalMs);
            } catch (e) {
                clearTimeout(timeout);

                console.log(e.message);
            }
        }
    };
    xhttp.open('GET', '/contao/system_information/system_load', true);
    xhttp.send();
}

updateSystemLoad();
