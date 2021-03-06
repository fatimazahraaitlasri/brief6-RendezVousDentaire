@component('components.layout')
    @php
    $creneauList = ['de 10h a 10h30', 'de 11h a 11h30', 'de 14h a 14h30', 'de 15h a 15h30', 'de 16h a 16h30'];
    $subjects = ['traitment', 'Radiologie dentaire', 'urgence dentaire', 'soins dentaires'];
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    @endphp
    @push('styles')
        <link rel="stylesheet" href="css/create.css">
    @endpush

    <div class="create">
        <form method="POST" class="form">
            <label class="input"><span class="label">choose a date</span>

                <input type="date" value="{{ $date }}" name="date" min="{{ $tomorrow }}" id="date">
            </label>

            <label class="input"><span class="label">choose a slot</span>
                <select name="creneau" id="creneau">
                    <option value="" disabled>please select a slot</option>
                    @foreach ($creneauList as $index => $item)
                        @if ($creneau === $index || !isset($usedSlots[$index]))
                            <option value="{{ $index }}" {{ $index === $creneau ? 'selected' : '' }}>
                                {{ $item }}</option>
                        @endif
                    @endforeach
                </select>
            </label>
            <label class="input"><span class="label">What is this about?</span>
                <select name="sujet" id="sujet">
                    @foreach ($subjects as $option)
                        <option value="{{ $option }}" {{ $option === $sujet ? 'selected' : '' }}>
                            {{ $option }}</option>
                    @endforeach
                </select>
            </label>
            <div class="btns">
                <a href="{{ createLink('/history') }}" class="cancel">cancel</a>
                <button type="submit">update</button>
            </div>

        </form>
    </div>
    <script>
        const creneauList = JSON.parse('@php echo json_encode($creneauList) @endphp');
        const creneauSelect = document.querySelector("#creneau");
        const dateInput = document.querySelector("#date");
        const currentCreneau = {{ $creneau }}

        dateInput.addEventListener("change", (e) => {
            fetch(`http://localhost/BRIEFAPITEST/rdv/all?date=${e.target.value}`)
                .then(res => res.json())
                .then(setupCreneau);
        })

        function setupCreneau(list) {
            creneauSelect.innerHTML =
                `<option value="" ${dateInput.value !== "{{ $date }}" && "selected"} disabled>please select a slot</option>`;
            creneauList.forEach((creneau, index) => {

                const isNotUsed = !list.includes(index);
                const isChosenDate = dateInput.value === "{{ $date }}";
                const isChosenCreneau = index === currentCreneau
                const isChosen = isChosenCreneau && isChosenDate;
                if (isNotUsed || isChosen) {
                    creneauSelect.innerHTML +=
                        `<option value="${index}" ${isChosen && "selected"} >${creneau}</option>`;
                }

            });
        }
    </script>
@endcomponent
