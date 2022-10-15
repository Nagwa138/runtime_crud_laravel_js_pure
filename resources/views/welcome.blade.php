<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
    </head>
    <body>
        <div class="message"></div>
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

            // current will not have dashed border

            let dragItem = null;

            function loadSections()
            {

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
                        //handle errors
                        if(data.status)
                        {
                            let firstSections = data.sections
                            let tbody = document.querySelector('.container:first-of-type table tbody')
                            for(let section in firstSections)
                            {
                                let sectionTr = document.createElement('tr')
                                // sectionTr.setAttribute('dragstart', 'dragStart(event)')
                                // sectionTr.setAttribute('ondragend', 'dragEnd(event)')
                                sectionTr.setAttribute('draggable', 'true')
                                sectionTr.setAttribute('id', 'tr-1-' + firstSections[section]['id'])

                                // sectionTr.setAttribute('ondrag', 'drag(event)')

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
                    url:'{{route("second_sections.index")}}',
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
                                // sectionTr.setAttribute('dragstart', 'dragStart(event)')
                                // sectionTr.setAttribute('ondragend', 'dragEnd(event)')
                                sectionTr.setAttribute('draggable', 'true')
                                sectionTr.setAttribute('id', 'tr-2-' + firstSections[section]['id'])

                                // sectionTr.setAttribute('ondrag', 'drag(event)')


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

            let targets = document.querySelectorAll('.drop-target')

            targets.forEach(target => {
                target.addEventListener('dragover', function (event) {
                    event.preventDefault()
                    let currentContainer = event.target.closest('.container')
                    let currentTable = currentContainer.querySelector('table')
                    currentTable.style.opacity = '0.5'
                    currentTable.style.border = '1px dashed black'
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
                    currentTbody.parentElement.style.opacity = '1'
                    currentTbody.parentElement.style.border = '0'
                    moveSection(dragItem, getNodeIndex(currentContainer))
                    let sectionId = dragItem.querySelector('td:first-child').innerText
                    removeSection(sectionId, dragItem, getNodeIndex(dragItem.closest('.container')))
                })
            })


            function addSection(btn, sectionNumber)
            {
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
                let inputs = sectionNumber == 1 ? document.querySelectorAll('.container:first-of-type table input') :
                    document.querySelectorAll('.container:last-of-type table input')
                inputs.forEach(input => input.value = '')
            }

            function deleteSection(btn, sectionNumber) {
                let sectionTr = btn.closest('tr')
                let id = sectionTr.querySelector(':first-child')
                removeSection(id.innerText, sectionTr , sectionNumber)
            }

            function editSection(element, sectionNumber)
            {

                // change td to inputs
                // get data values

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

                    let url = Number(sectionNumber) == 1 ? '{{route("first_sections.update", ":id")}}' : '{{route("second_sections.update", ":id")}}'
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

                                showMessage(data.message)
                            }
                        }
                    })

                    element.classList.add('fa-pen-to-square')
                    element.classList.remove('fa-check')
                    element.style.color  ='#5944bb'
                }
            }

            let tables = document.querySelectorAll('table')

            tables.forEach(table =>  table.ondragstart = (event) => event.target.tagName === 'TR' ? dragItem = event.target : '')

            function moveSection(sectionTr, newSectionNumber) {
                let name = sectionTr.querySelector('td:nth-child(2)').innerText
                let birthDate = sectionTr.querySelector('td:nth-child(3)').innerText
                let createdAt = sectionTr.querySelector('td:nth-child(4)').innerText

                let section = {
                    name : name,
                    birth_date : birthDate,
                    created_at : createdAt
                }
                createSection(section, newSectionNumber)
            }

            function createSection(sectionData, sectionNumber) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let token = "{{ csrf_token()}}";
                sectionData['_token'] = token
                $.ajax({
                    type: 'POST',
                    url: Number(sectionNumber) == 1 ? '{{route("first_sections.store")}}' : '{{route("second_sections.store")}}' ,
                    data: sectionData,
                    success: function (data) {
                        if(data.status) {
                            let tbody = Number(sectionNumber) == 1 ?
                                document.querySelector('.container:first-of-type table tbody')
                                : document.querySelector('.container:last-of-type table tbody')
                            let sectionTr = document.createElement('tr')
                            sectionTr.setAttribute('draggable', 'true')
                            sectionTr.setAttribute('id', 'tr-' +sectionNumber+ '-' + data.section.id)
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
                            clearInputs(sectionNumber)
                            showMessage(data.message)
                        }
                    }
                })
            }

            function removeSection(sectionId, element, sectionNumber)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let token = "{{ csrf_token()}}";

                let url = Number(sectionNumber) == 1 ? '{{route("first_sections.destroy", ":id")}}' : '{{route("second_sections.destroy", ":id")}}'
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
                            showMessage(data.message)
                        }
                    }
                })
            }

            function showMessage(messageText) {
                let message = document.querySelector('.message')
                message.innerHTML = messageText
                message.style.display = 'none'
                message.style.setProperty('animation', 'moving 3s')
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
