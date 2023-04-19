<?php
if (!class_Exists('lines')) {
    require_once('./api/lines.php');
}

use api\lines;
?>
<button id="modal-open" tabindex="0" class="fixed bottom-4 left-8 hover:bg-fuchsia-800 flex z-[80] justify-center items-center rounded-full drop-shadow-xl hover:scale-105 w-20 h-20 bg-fuchsia-900">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9 stroke-white">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
    </svg>
</button>
<div id="modal-bg" class="modal-bg hidden fixed inset-0 w-full h-screen bg-gray-500 z-[60] bg-opacity-25 backdrop-blur"></div>
<div id="modal-sq" class="modal-closed hidden fixed inset-0 w-full h-screen bg-transparent z-[60] flex justify-center items-center">

    <form id="modal-form" method="POST" action="./lib/schedule.php" class="relative w-[650px] h-[150px] bg-white rounded-xl flex justify-around items-center">
        <button id="modal-closer" type="button" class="absolute top-3 right-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="flex flex-col space-y-1">
            <label for="origin" class="font-semibold">Origen</label>
            <input autocomplete="off" required list="origin-list" id="origin" name="origin" class="origin-modal w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
            <datalist id="origin-list">
                <?php
                $stations = lines::getAllStations();
                foreach ($stations as $station) : ?>
                    <option value='<?= $station["name"] ?>'></option>";

                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="flex flex-col space-y-1">
            <label for="formDestiny" class="font-semibold">Destino</label>
            <input autocomplete="off" required list="destiny-list" id="destiny" name="destiny" class="destiny-modal w-44 bg-white p-2 rounded-lg border-2 border-fuchsia-900">
            <datalist name="destiny" id="destiny-list">
                <?php
                $stations = lines::getAllStations();
                foreach ($stations as $station) : ?>
                    <option value='<?= $station["name"] ?>'></option>";

                <?php endforeach; ?>
            </datalist>
        </div>
        <input type="hidden" name="time" class="time-modal">
        <input type="hidden" name="date" class="date-modal">
        <button type="submit" class="mt-6 rounded-lg py-3 px-2 bg-fuchsia-900 text-white text-center font-semibold w-44">Buscar</button>
    </form>
</div>
<script>
    const modalOpen = document.getElementById("modal-open");

    function toggleModal() {
        const modalBg = document.getElementById("modal-bg");
        const modalSq = document.getElementById("modal-sq");
        modalBg.classList.toggle("hidden");
        modalSq.classList.toggle("hidden");
        modalSq.classList.toggle("modal-closed");
        modalSq.classList.toggle("modal-open")
        if (modalSq.classList.contains("modal-open")){
            const origin = document.querySelector(".origin-modal");
            focus(origin)
        }
    }

    document.addEventListener("click", (e) => {
        if (e.target.id === "modal-sq") {
            toggleModal();
        }
    });

    const modalForm = document.getElementById("modal-form");
    modalForm.addEventListener("submit", e => {
        e.preventDefault();
        const origin = document.querySelector(".origin-modal");
        const destiny = document.querySelector(".destiny-modal");
        const station_list = document.querySelector("#origin-list");
        let origin_value = origin.value;
        let destiny_value = destiny.value;
        let origin_valid = false;
        let destiny_valid = false;
        for (let i = 0; i < station_list.options.length; i++) {
            if (station_list.options[i].value == origin_value) {
                origin_valid = true;
            }
            if (station_list.options[i].value == destiny_value) {
                destiny_valid = true;
            }
        }
        if (origin_valid && destiny_valid && origin_value != destiny_value) {
            modalForm.submit();
        } else if (origin_value == destiny_value) {
            alert("La estación de origen y destino no pueden ser iguales");
        } else {
            alert("Por favor, seleccione una estación válida");
        }
    })

    const formTime = document.querySelector(".time-modal");
    const formDate = document.querySelector(".date-modal")
    const date = new Date();
    const time = (date.getHours() >= 10 ? date.getHours() : "0" + date.getHours()) + ":00";
    const dateFormated = date.getFullYear() + "-" + ((date.getMonth() + 1) >= 10 ? (date.getMonth() + 1) : "0" + (date.getMonth() + 1)) + "-" + (date.getDate() >= 10 ? date.getDate() : "0" + date.getDate());
    formTime.value = time;
    formDate.value = dateFormated;

    const modalCloser = document.getElementById("modal-closer");
    modalCloser.addEventListener("click", toggleModal);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            toggleModal();
        }
    });


    modalOpen.addEventListener("click", toggleModal);
</script>