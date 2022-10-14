<html>
    <head>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
            }

            body{
                overflow-x: hidden;
                /*height: fit-content;*/
            }

            section {
                min-height: 100vh;
                display: flex;
            }

            section .container {
                width:50%;
                height: inherit;
                /*border: 1px solid darkgrey;*/
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                text-align: center;
                align-items: center;
            }

            section .container:first-of-type {
                border-right: 1px solid darkgrey;
            }

            section .container:last-of-type {
                border-left: 1px solid darkgrey;
            }
            section .container p {
                height: 15vh;
                display: flex;
                font-size: 18px;
                font-weight: bold;
                justify-content: center;
                align-items: center;
            }

            input {

                border: 1px solid aliceblue;
                padding: 10px 15px;
                outline: none;
                border-radius: 10px;
            }

            button{
                background-color: darkcyan;
                border-radius: 5px;
                border: 0;
                color:white;
                padding: 10px 20px;
            }

            input:focus {
                box-shadow: 0 1px 2px rgba(0,0,0,0.07),
                0 2px 4px rgba(0,0,0,0.07),
                0 4px 8px rgba(0,0,0,0.07),
                0 8px 16px rgba(0,0,0,0.07),
                0 16px 32px rgba(0,0,0,0.07),
                0 32px 64px rgba(0,0,0,0.07);
            }
            table, tbody {
                text-align: center;
            }

            td, th {
                padding: 10px 0;
            }
            section .container table {
                width: 90%;
                height: fit-content;

            }

            .message {
                position: absolute;
                z-index: 1;
                padding: 15px;
                width: 250px;
                text-align: center;
                background-color: white;
                border: 3px solid  #20e16e;
                color: #20e16e;
                right: -300px;
                top: 20px;
                border-radius: 20px;
                transform: rotate(0);
                display: none;
            }

            @keyframes moving {
                0%{
                    right: -300px;
                    transform: rotate(0);
                }

                25% {
                    right: 20px;
                    transform: rotate(0);
                }

                50% {
                    right: 20px;
                    transform: rotate(-10deg);
                }

                75% {
                    right: 20px;
                    transform: rotate(10deg);
                }

                100% {
                    right: -300px;
                    transform: rotate(0deg);
                }
            }

        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="message"></div>
        <section>
            <div class="container">
                <p>Section One</p>
                <table class="droptarget"  ondragenter="dragEntered()" ondragover="dragOver(event)" ondragleave="dragLeave()" ondrop="drop(event)">
                    <thead>
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" name="name" placeholder="Name">
                        </td>
                        <td>
                            <input type="text" name="birth_date" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')">
                        </td>
                        <td>
                            <input  type="text" onfocus="(this.type='datetime-local')" name="created_at" placeholder="Created at" onblur="(this.type='text')">
                        </td>
                        <td>
                            <button onclick="addSection(this, 1)">
                                Add
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Birth Date</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <p>Section Two</p>
                <table class="droptarget"  ondragenter="dragEntered()" ondragover="dragOver(event)" ondragleave="dragLeave()" ondrop="drop(event)">
                    <thead>
                    <tr>
                        <td></td>
                        <td>
                            <input type="text" name="name" placeholder="Name">
                        </td>
                        <td>
                            <input type="text" name="birth_date" placeholder="Date of birth" onfocus="(this.type='date')" onblur="(this.type='text')">
                        </td>
                        <td>
                            <input  type="text" onfocus="(this.type='datetime-local')" name="created_at" placeholder="Created at" onblur="(this.type='text')">
                        </td>
                        <td>
                            <button onclick="addSection(this, 2)">
                                Add
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Birth Date</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script>

            // use progress bar

            function loadSections()
            {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:'GET',
                    url:'{{route('first_sections.index')}}',
                    data:{},
                    success:function(data){
                        //handle errors
                        if(data.status)
                        {
                            let firstSections = data.sections
                            let tbody = document.querySelector('.container:first-of-type table tbody')
                            for(let section in firstSections)
                            {
                                let sectionTr = document.createElement('tr')

                                sectionTr.classList.add('draggable-item')
                                sectionTr.setAttribute('draggable', 'true')
                                sectionTr.setAttribute('ondrag', 'dragging(event)')
                                sectionTr.setAttribute('ondragstart', 'dragStarted(event)')
                                sectionTr.setAttribute('ondragend', 'dragFinished(event)')
                                let idTd = document.createElement('td')
                                idTd.innerHTML = firstSections[section]['id']
                                sectionTr.appendChild(idTd)
                                let nameTd = document.createElement('td')
                                nameTd.innerHTML = firstSections[section]['name']
                                sectionTr.appendChild(nameTd)
                                let birthDateTd = document.createElement('td')
                                birthDateTd.innerHTML = firstSections[section]['birth_date']
                                sectionTr.appendChild(birthDateTd)
                                let createdAtTd = document.createElement('td')
                                createdAtTd.innerHTML = firstSections[section]['created_at']
                                sectionTr.appendChild(createdAtTd)
                                let actionTd = document.createElement('td')
                                let deleteBtn = document.createElement('button')

                                deleteBtn.style.fontSize = '18px'
                                deleteBtn.style.display = 'flex'
                                deleteBtn.style.gap = '20px'
                                deleteBtn.style.justifyContent = 'space-between'
                                deleteBtn.style.cursor = 'pointer'
                                deleteBtn.style.backgroundColor = 'transparent'
                                let editIcon  = document.createElement('i')
                                editIcon.classList.add('fa-solid', 'fa-pen-to-square')
                                let trashIcon  = document.createElement('i')
                                trashIcon.classList.add('fa-solid', 'fa-trash')
                                deleteBtn.appendChild(trashIcon)
                                deleteBtn.appendChild(editIcon)
                                actionTd.appendChild(deleteBtn)
                                sectionTr.appendChild(actionTd)
                                actionTd.appendChild(deleteBtn)
                                sectionTr.appendChild(actionTd)
                                tbody.appendChild(sectionTr)

                                trashIcon.style.color = '#da2557'
                                trashIcon.setAttribute('onclick', 'deleteSection(this, 1)')
                                editIcon.style.color = '#5944bb'
                                editIcon.setAttribute('onclick', 'editSection(this,  1)')
                            }

                        }
                    }
                });
                $.ajax({
                    type:'GET',
                    url:'{{route('second_sections.index')}}',
                    data:{},
                    success:function(data){
                        //handle errors
                        if(data.status)
                        {
                            let firstSections = data.sections
                            let tbody = document.querySelector('.container:last-of-type table tbody')
                            for(let section in firstSections)
                            {
                                let sectionTr = document.createElement('tr')
                                sectionTr.classList.add('draggable-item')
                                sectionTr.setAttribute('draggable', 'true')
                                let idTd = document.createElement('td')
                                idTd.innerHTML = firstSections[section]['id']
                                sectionTr.appendChild(idTd)
                                let nameTd = document.createElement('td')
                                nameTd.innerHTML = firstSections[section]['name']
                                sectionTr.appendChild(nameTd)
                                let birthDateTd = document.createElement('td')
                                birthDateTd.innerHTML = firstSections[section]['birth_date']
                                sectionTr.appendChild(birthDateTd)
                                let createdAtTd = document.createElement('td')
                                createdAtTd.innerHTML = firstSections[section]['created_at']
                                sectionTr.appendChild(createdAtTd)
                                let actionTd = document.createElement('td')
                                let deleteBtn = document.createElement('button')

                                deleteBtn.style.fontSize = '18px'
                                deleteBtn.style.display = 'flex'
                                deleteBtn.style.gap = '20px'
                                deleteBtn.style.justifyContent = 'space-between'
                                deleteBtn.style.cursor = 'pointer'
                                deleteBtn.style.backgroundColor = 'transparent'

                                let editIcon  = document.createElement('i')
                                editIcon.classList.add('fa-solid', 'fa-pen-to-square')
                                let trashIcon  = document.createElement('i')
                                trashIcon.classList.add('fa-solid', 'fa-trash')
                                deleteBtn.appendChild(trashIcon)
                                deleteBtn.appendChild(editIcon)
                                actionTd.appendChild(deleteBtn)
                                sectionTr.appendChild(actionTd)
                                tbody.appendChild(sectionTr)

                                trashIcon.style.color = '#da2557'
                                trashIcon.setAttribute('onclick', 'deleteSection(this, 2)')
                                editIcon.style.color = '#5944bb'
                                editIcon.setAttribute('onclick', 'editSection(this,  2)')
                            }

                        }
                    }
                });
            }

            loadSections()

            function addSection(btn, sectionNumber)
            {
               let currentTr = btn.closest('tr')

                let name = currentTr.querySelector('input[name="name"]')
                let birthDate = currentTr.querySelector('input[name="birth_date"]')
                let createdAt = currentTr.querySelector('input[name="created_at"]')



                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let token = "{{ csrf_token()}}";

                $.ajax({
                    type: 'POST',
                    url: Number(sectionNumber) == 1 ? '{{route('first_sections.store')}}' : '{{route('second_sections.store')}}' ,
                    data: {
                        _token: token,
                        name: name.value,
                        birth_date: birthDate.value,
                        created_at: createdAt.value,
                    },
                    success: function (data) {
                        if(data.status) {
                            let tbody = Number(sectionNumber) == 1 ?
                                document.querySelector('.container:first-of-type table tbody')
                                : document.querySelector('.container:last-of-type table tbody')
                                let sectionTr = document.createElement('tr')
                                sectionTr.classList.add('draggable-item')
                                sectionTr.setAttribute('draggable', 'true')
                                let idTd = document.createElement('td')
                                idTd.innerHTML = data.section.id
                                sectionTr.appendChild(idTd)
                                let nameTd = document.createElement('td')
                                nameTd.innerHTML =data.section.name
                                sectionTr.appendChild(nameTd)
                                let birthDateTd = document.createElement('td')
                                birthDateTd.innerHTML = data.section.birth_date
                                sectionTr.appendChild(birthDateTd)
                                let createdAtTd = document.createElement('td')
                                createdAtTd.innerHTML = data.section.created_at
                                sectionTr.appendChild(createdAtTd)
                                let actionTd = document.createElement('td')
                                let deleteBtn = document.createElement('button')
                                deleteBtn.style.fontSize = '18px'
                                deleteBtn.style.display = 'flex'
                                deleteBtn.style.gap = '20px'
                                deleteBtn.style.justifyContent = 'space-between'
                                deleteBtn.style.cursor = 'pointer'
                                deleteBtn.style.backgroundColor = 'transparent'
                                let editIcon  = document.createElement('i')
                                editIcon.classList.add('fa-solid', 'fa-pen-to-square')
                                let trashIcon  = document.createElement('i')
                                trashIcon.classList.add('fa-solid', 'fa-trash')
                                deleteBtn.appendChild(trashIcon)
                                deleteBtn.appendChild(editIcon)
                                actionTd.appendChild(deleteBtn)
                                sectionTr.appendChild(actionTd)
                                tbody.appendChild(sectionTr)

                            trashIcon.style.color = '#da2557'
                            trashIcon.setAttribute('onclick', 'deleteSection(this, '+sectionNumber+')')
                            editIcon.style.color = '#5944bb'
                            editIcon.setAttribute('onclick', 'editSection(this,  '+sectionNumber+')')

                            name.value =''
                            birthDate.value =''
                            createdAt.value =''
                            let message = document.querySelector('.message')
                            message.innerHTML = data.message
                            message.style.setProperty('animation', 'moving 3s')
                            message.style.display = 'block'
                            setTimeout(function() {
                                message.style.display = 'none'
                            }, 3000);
                        }
                    }
                })
            }

            function deleteSection(btn, sectionNumber) {
                let sectionTr = btn.closest('tr')

                let id = sectionTr.querySelector(':first-child')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let token = "{{ csrf_token()}}";

                let url = Number(sectionNumber) == 1 ? '{{route('first_sections.destroy', ':id')}}' : '{{route('second_sections.destroy', ':id')}}'
                url = url.replace(':id', id.innerText)

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        _token: token
                    },
                    success: function (data) {
                        if(data.status) {
                            sectionTr.remove()
                            let message = document.querySelector('.message')
                            message.innerHTML = data.message
                            message.style.setProperty('animation', 'moving 3s')
                            message.style.display = 'block'
                            setTimeout(function() {
                                message.style.display = 'none'
                            }, 3000);
                        }
                    }
                })
            }

            function editSection(element, sectionNumber)
            {

                // change td to inputs
                // get data values

                let currentTr = element.closest('tr')

                let nameTd = currentTr.querySelector(':nth-child(2)')
                let birthDateTd = currentTr.querySelector(':nth-child(3)')
                let createdAtTd = currentTr.querySelector(':nth-child(4)')



                // create inputs and set data as values to the inputs

                // set values of inputs

                // change icon of the button

                if(element.classList.contains('fa-pen-to-square'))
                {


                    let nameInput = document.createElement('input')
                    nameInput.setAttribute('type', 'text')
                    nameInput.setAttribute('value', nameTd.innerText)
                    nameInput.setAttribute('name', 'name')


                    let birthDateInput = document.createElement('input')
                    birthDateInput.setAttribute('type', 'date')
                    birthDateInput.setAttribute('value', birthDateTd.innerText)
                    birthDateInput.setAttribute('name', 'birth_date')

                    let createdAtInput = document.createElement('input')
                    createdAtInput.setAttribute('type', 'datetime-local')
                    createdAtInput.setAttribute('value', createdAtTd.innerText)
                    createdAtInput.setAttribute('name', 'created_at')

                    nameTd.innerHTML = ''
                    nameTd.appendChild(nameInput)

                    birthDateTd.innerHTML = ''
                    birthDateTd.appendChild(birthDateInput)

                    createdAtTd.innerHTML = ''
                    createdAtTd.appendChild(createdAtInput)

                    element.classList.remove('fa-pen-to-square')
                    element.classList.add('fa-check')
                    element.style.color  ='green'
                } else {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    let idTd = currentTr.querySelector(':first-child')
                    let nameInput = currentTr.querySelector('input[name="name"]')
                    let birthDateInput = currentTr.querySelector('input[name="birth_date"]')
                    let createdAtInput = currentTr.querySelector('input[name="created_at"]')

                    let url = Number(sectionNumber) == 1 ? '{{route('first_sections.update', ':id')}}' : '{{route('second_sections.update', ':id')}}'
                    url = url.replace(':id', idTd.innerText)

                    let token = "{{ csrf_token()}}";

                    $.ajax({
                        type: 'PATCH',
                        url: url,
                        data: {
                            _token: token,
                            name: nameInput.value,
                            birth_date: birthDateInput.value,
                            created_at: createdAtInput.value,
                        },
                        success: function (data) {
                            console.log(data)
                            if(data.status) {

                                nameTd.innerHTML = data.section.name
                                birthDateTd.innerHTML = data.section.birth_date
                                createdAtTd.innerHTML = data.section.created_at

                                let message = document.querySelector('.message')
                                message.innerHTML = data.message
                                message.style.setProperty('animation', 'moving 3s')
                                message.style.display = 'block'
                                setTimeout(function() {
                                    message.style.display = 'none'
                                }, 3000);
                            }
                        }
                    })
                    // remove inputs

                    // set new data as inner html of tds
                    element.classList.add('fa-pen-to-square')
                    element.classList.remove('fa-check')
                    element.style.color  ='#5944bb'
                }
            }

            function dragStarted(event) {
                // add class and cursor
                console.log('starting drag')
            }

            function dragging(event) {
                console.log('dragging')
            }

            function dragFinished(event) {
                // remove class and cursor
                console.log('finishing drag')
            }

            function dragEntered() {
                console.log('drag entered me')
            }

            function dragOver(event)
            {
                console.log('drag is over me')

                event.preventDefault();
            }

            function dragLeave() {
                console.log('drag left me')
            }

            function drop(event)
            {
                console.log('something dropped on me')
                event.preventDefault();
                var data = event.dataTransfer.getData("Text");
            }
        </script>
    </body>
</html>
