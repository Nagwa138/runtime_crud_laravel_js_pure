<html>
    <head>
        <title>Laravel with JS</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
    </head>
    <body>
        <div class="message"></div>
        <div class="error-message"></div>
        <section>
            <div class="container">
                <p>Section One</p>
                <table class="drop-target" id="section-one">
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
                <table class="drop-target" id="section-two">
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

            // make design of the container

            let dragItem = null;

            function loadSections() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:'GET',
                    url:'{{route("first_sections.index")}}',
                    data:{},
                    success:function(data){
                        if(data.status)
                        {
                            let firstSections = data.sections
                            let tbody = document.querySelector('.container:first-of-type table tbody')
                            for(let section in firstSections)
                            {
                                let sectionTr = generateNewRow(firstSections[section], 1)
                                tbody.appendChild(sectionTr)
                            }
                        }
                    }
                });

                $.ajax({
                    type:'GET',
                    url:'{{route("second_sections.index")}}',
                    data:{},
                    success:function(data){
                        if(data.status)
                        {
                            let secondSections = data.sections
                            let tbody = document.querySelector('.container:last-of-type table tbody')
                            for(let section in secondSections)
                            {
                                let sectionTr = generateNewRow(secondSections[section], 2)
                                tbody.appendChild(sectionTr)
                            }
                        }
                    }
                });
            }

            loadSections()

            let targets = document.querySelectorAll('.drop-target')

            targets.forEach(target => {
                target.addEventListener('dragover', function (event) {
                    event.preventDefault()
                    let currentContainer = event.target.closest('.container')
                    let currentTable = currentContainer.querySelector('table')
                    if(dragItem.closest('table') !== currentTable)
                    {
                        currentTable.style.opacity = '0.5'
                        currentTable.style.border = '1px dashed black'
                    }
                })

                target.addEventListener('dragenter', function (event) {
                    event.preventDefault()
                })

                target.addEventListener('dragleave', function (event) {
                    let currentContainer = event.target.closest('.container')
                    let currentTable = currentContainer.querySelector('table')
                    currentTable.style.opacity = '1'
                    currentTable.style.border = '0'
                })

                target.addEventListener('drop', function (event) {
                    event.preventDefault();
                    let currentContainer = event.target.closest('.container')
                    let currentTbody = currentContainer.querySelector('table tbody')
                    if(dragItem.closest('table') !== currentTbody.closest('table')) {
                        currentTbody.parentElement.style.opacity = '1'
                        currentTbody.parentElement.style.border = '0'
                        let moved = moveSection(dragItem, getNodeIndex(currentContainer), event)
                        if (moved === true) removeSection(dragItem, getNodeIndex(dragItem.closest('.container')), 'Moved Successfully!')
                    }
                })
            })

            function addSection(btn, sectionNumber) {
                let currentTr = btn.closest('tr')
                let name = currentTr.querySelector('input[name="name"]')
                let birthDate = currentTr.querySelector('input[name="birth_date"]')
                let createdAt = currentTr.querySelector('input[name="created_at"]')

                let sectionData = {
                    name: name.value,
                    birth_date: birthDate.value,
                    created_at: createdAt.value,
                }
                createSection(sectionData, sectionNumber)
            }

            function clearInputs(sectionNumber) {
                let inputs = Number(sectionNumber) === 1 ?
                    document.querySelectorAll('.container:first-of-type table input') :
                    document.querySelectorAll('.container:last-of-type table input')
                inputs.forEach(input => input.value = '')
            }

            function deleteSection(btn, sectionNumber) {
                let sectionTr = btn.closest('tr')
                let id = sectionTr.querySelector(':first-child')
                removeSection(sectionTr , sectionNumber)
            }

            function editSection(element, sectionNumber) {
                let currentTr = element.closest('tr')

                let nameTd = currentTr.querySelector(':nth-child(2)')
                let birthDateTd = currentTr.querySelector(':nth-child(3)')
                let createdAtTd = currentTr.querySelector(':nth-child(4)')

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

                    let url = Number(sectionNumber) === 1 ?
                        '{{route("first_sections.update", ":id")}}' :
                        '{{route("second_sections.update", ":id")}}'
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
                            if(data.status) {
                                nameTd.innerHTML = data.section.name
                                birthDateTd.innerHTML = data.section.birth_date
                                createdAtTd.innerHTML = data.section.created_at
                                showMessage(data.message)
                                element.classList.add('fa-pen-to-square')
                                element.classList.remove('fa-check')
                                element.style.color  ='#5944bb'
                            } else {
                                showMessage('An Unexpected error occurred!', true)
                            }
                        },
                        error : function (errorList) {
                            if(errorList.responseJSON.hasOwnProperty('errors')) {

                                removeValidationEffect(currentTr)

                                for (const errorKey in errorList.responseJSON.errors) {
                                        let input = currentTr.querySelector('input[name="'+errorKey+'"]')
                                        input.style.border = '1px solid red'
                                        let messagePara = document.createElement('p')
                                        messagePara.innerHTML = errorList.responseJSON.errors[errorKey]
                                        messagePara.style.color = 'red'
                                        messagePara.style.fontSize = '14px'
                                        input.parentElement.appendChild(messagePara)
                                }
                            } else if(errorList.responseJSON.hasOwnProperty('status')) {
                                showMessage(errorList.responseJSON.message, true)
                            } else {
                                showMessage(errorList.responseText, true)
                            }
                        }
                    })
                }
            }

            let tables = document.querySelectorAll('table')

            tables.forEach(table =>  table.ondragstart = (event) => event.target.tagName === 'TR' ? dragItem = event.target : '')

            function moveSection(sectionTr, newSectionNumber, event) {
                let name = sectionTr.querySelector('td:nth-child(2)').innerText
                let birthDate = sectionTr.querySelector('td:nth-child(3)').innerText
                let createdAt = sectionTr.querySelector('td:nth-child(4)').innerText

                let section = {
                    name : name,
                    birth_date : birthDate,
                    created_at : createdAt
                }

                return createSection(section, newSectionNumber, event)

            }

            function createSection(sectionData, sectionNumber, event = null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let requestStatus = false

                sectionData['_token'] = "{{ csrf_token()}}"
                $.ajax({
                    type: 'POST',
                    url: Number(sectionNumber) === 1 ? '{{route("first_sections.store")}}' : '{{route("second_sections.store")}}' ,
                    data: sectionData,
                    global: false, async:false,
                    success: function (data) {
                        requestStatus = data.status
                        if(data.status) {
                            let inputsTr = Number(sectionNumber) === 1 ?
                                document.querySelector('.container:first-of-type table thead :first-child')
                                : document.querySelector('.container:last-of-type table thead :first-child')

                            removeValidationEffect(inputsTr)

                            let tbody = Number(sectionNumber) === 1 ?
                                document.querySelector('.container:first-of-type table tbody')
                                : document.querySelector('.container:last-of-type table tbody')
                            let sectionTr = generateNewRow(data.section, sectionNumber)
                            tbody.appendChild(sectionTr)
                            clearInputs(sectionNumber)
                            showMessage(data.message)
                        } else {
                            showMessage('An Unexpected error occurred!', true)
                        }
                    },
                    error : function (errorList) {
                        requestStatus = false
                        if(errorList.responseJSON.hasOwnProperty('errors')) {
                            let inputsTr = Number(sectionNumber) === 1 ?
                                document.querySelector('.container:first-of-type table thead :first-child')
                                : document.querySelector('.container:last-of-type table thead :first-child')

                            removeValidationEffect(inputsTr)

                            for (const errorKey in errorList.responseJSON.errors) {

                                if(event == null)
                                {
                                    let input = inputsTr.querySelector('input[name="'+errorKey+'"]')
                                    input.style.border = '1px solid red'
                                    let messagePara = document.createElement('p')
                                    messagePara.innerHTML = errorList.responseJSON.errors[errorKey]
                                    messagePara.style.color = 'red'
                                    messagePara.style.fontSize = '14px'
                                    input.parentElement.appendChild(messagePara)
                                } else {
                                    showMessage(errorList.responseJSON.errors[errorKey], true)
                                }
                            }
                        } else if(errorList.responseJSON.hasOwnProperty('status')) {
                            showMessage(errorList.responseJSON.message, true)
                        } else {
                            showMessage(errorList.responseText, true)
                        }
                    }
                })
                return requestStatus;
            }

            function removeValidationEffect(element) {

                let attributes = ['name', 'birth_date', 'created_at']

                for (const attribute of attributes) {
                    let input = element.querySelector('input[name="'+attribute+'"]')
                    input.style.border = '1px solid aliceblue'
                    input.parentElement.querySelectorAll('p').forEach(p => p.remove())
                }
            }

            function generateNewRow(section, sectionNumber) {
                let sectionTr = document.createElement('tr')
                sectionTr.setAttribute('draggable', 'true')
                sectionTr.setAttribute('id', 'tr-' +sectionNumber+ '-' + section.id)
                let idTd = document.createElement('td')
                idTd.innerHTML = section.id
                sectionTr.appendChild(idTd)
                let nameTd = document.createElement('td')
                nameTd.innerHTML = section.name
                sectionTr.appendChild(nameTd)
                let birthDateTd = document.createElement('td')
                birthDateTd.innerHTML = section.birth_date
                sectionTr.appendChild(birthDateTd)
                let createdAtTd = document.createElement('td')
                createdAtTd.innerHTML = section.created_at
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
                trashIcon.style.color = '#da2557'
                trashIcon.setAttribute('onclick', 'deleteSection(this, '+sectionNumber+')')
                editIcon.style.color = '#5944bb'
                editIcon.setAttribute('onclick', 'editSection(this,  '+sectionNumber+')')
                return sectionTr;
            }

            function removeSection(element, sectionNumber, messageText = null) {
                let sectionId = element.querySelector(':first-child').innerText
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let token = "{{ csrf_token()}}";

                let url = Number(sectionNumber) === 1 ?
                    '{{route("first_sections.destroy", ":id")}}' :
                    '{{route("second_sections.destroy", ":id")}}'
                url = url.replace(':id', sectionId)

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        _token: token
                    },
                    success: function (data) {
                        if(data.status) {
                            element.remove()
                            showMessage(messageText === null ? data.message : messageText)
                        }
                    }
                })
            }

            function showMessage(messageText, error = null) {

                // make error message

                let message = document.querySelector('.message')
                if(error != null)
                {
                    message = document.querySelector('.error-message')
                    message.style.display = 'none'
                    message.style.setProperty('animation', 'vibrate 3s')
                } else {
                    message.style.display = 'none'
                    message.style.setProperty('animation', 'moving 3s')
                }
                message.innerHTML = messageText
                message.style.display = 'block'
                setTimeout(function() {
                    message.style.display = 'none'
                }, 3000);
            }

            function getNodeIndex(element) {
                return Array.prototype.indexOf.call(element.parentNode.childNodes, element)
            }

        </script>
    </body>
</html>
