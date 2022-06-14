'use strict';

document.addEventListener('DOMContentLoaded', function () {

/**---------- Авторизация --------------*/    
    //кнопка в форме авторизации
    const btnAuth = document.getElementById('doAuth');
    //обработчик формы авторизации
    if (btnAuth) {
        btnAuth.addEventListener('click', validateAuth);
    }
/**---------- Регистрация --------------*/   
    const btnReg = document.getElementById('doReg');
    if (btnReg) {
        btnReg.addEventListener('click', validateReg);
    }
/**------------ Профиль --------------*/  
    //кнопка сохранения изменений профиля
    const btnLk = document.getElementById('saveProfile');
    //карточка профиля
    const cardBody = document.querySelector('.card-body');
    //поле для загрузки фото профиля
    const addInput = document.getElementById('profile-photo');
    //событие срабатывает, когда меняется фото профиля
    if (addInput) {
        addInput.addEventListener('change', evt => preloadImg(evt, cardBody, 'img-account-profile rounded-circle mb-2'));
    }
    //если кнопка сохранения нажата, то отправляем на валидацию форму профиля
    if (btnLk) {
        btnLk.addEventListener('click', validateProfile);
    }

/**------------ Подписка ------------ */
    const form = document.getElementById('formSubscription');
    if (form) {
        form.addEventListener('submit', subscription);
    }

/**------------ Комментарий ------------ */
    //добавление комментарий
    const formComment = document.getElementById('formComment');
    if (formComment) {
        formComment.addEventListener('submit', addComment);
    }

    //управление кнопками комментария
    const boxComments = document.querySelector('.comments-box');
    if (boxComments) {
        //делегируем событие и находим кнопку утверждения на каждом комментарии
        boxComments.addEventListener('click', (event) => eventBtnComment('.approveComment', boxComments, event));
        //делегируем событие и находим кнопку отклонения на каждом комментарии
        boxComments.addEventListener('click', (event) => eventBtnComment('.rejectComment', boxComments, event));
    }
/**--------- Панель администратора---------- */
/**--- Администратор раздел Пользователи --- */
 //таблица пользователей
 const wrapTableUsers = document.querySelector('.wrapper-table-users');
 if (wrapTableUsers) {
     wrapTableUsers.addEventListener('click',  (event) => eventShowModal('user', '/admin/userDelete', event));
 }
/**------ Администратор раздел Статьи ------ */
    //поле для загрузки изображения статьи
    const addInputPostPthoto = document.getElementById('post-photo');
    //событие срабатывает, когда меняется фото профиля
    if (addInputPostPthoto) {
        addInputPostPthoto.addEventListener('change', evt => preloadImg(evt, cardBody, 'mb-2'));
    }
    //событие удаление стратьи на таблицу статей
    const wrapTablePosts = document.querySelector('.wrapper-table-posts');
    if (wrapTablePosts) {
        wrapTablePosts.addEventListener('click',  (event) => eventShowModal('post', '/admin/postDelete', event));
    }
/**----- Администратор раздел Подписки ----- */
    //событие удаление подписки из таблицы НЕаторизованных пользователей
    const wrapTableSubscrNoAuth = document.querySelector('.wrapper-table-no-auth-subscriptions');
    if (wrapTableSubscrNoAuth) {
        wrapTableSubscrNoAuth.addEventListener('click',  (event) => eventShowModal('no-auth-subscription', '/admin/subscrDeleteNoAuth', event));
    }
    //событие удаление подписки из таблицы аторизованных пользователей
    const wrapTableSubscrAuth = document.querySelector('.wrapper-table-auth-subscriptions');
    if (wrapTableSubscrAuth) {
        wrapTableSubscrAuth.addEventListener('click',  (event) => eventShowModal('auth-subscription', '/admin/subscrDeleteAuth', event));
    }
/**----- Администратор раздел Комментарии ----- */
    //событие удаление комментария из таблицы 
    const wrapTableComment = document.querySelector('.wrapper-table-comments');
    if (wrapTableComment) {
        wrapTableComment.addEventListener('click',  (event) => eventShowModal('comment', '/admin/commentDelete', event));
    }
/**----- Администратор раздел Страницы ----- */
    //событие удаление страниц из таблицы 
    const wrapTablePages = document.querySelector('.wrapper-table-pages');
    if (wrapTablePages) {
        wrapTablePages.addEventListener('click',  (event) => eventShowModal('page', '/admin/pageDelete', event));
}
/**------ Пагинация на всех разделах администратора ------ */
    const selectAdmin = document.getElementById('adminRecordsSelect');
    if (selectAdmin) {
        selectAdmin.addEventListener('change', (event) => {
            const url = new URL(document.location);
            const searchParams = url.searchParams;
            const urlCount = searchParams.get('count');
            const urlPage = searchParams.get('page');
            const protocol = location.protocol + '//';
            const host = window.location.host;
            const pathname = window.location.pathname;
            const path = protocol + host + pathname; 

            if (urlPage) {
                window.location.href = path + '?page=' + urlPage + '&count=' + event.target.value;
            } else {
                window.location.href = path + '?page=1' + '&count=' + event.target.value;
            }           
        });
    }

/**------ Пагинация в разделе подписок администратора ------ */
const selectAdminSubNoAuth = document.getElementById('adminRecordsSelectNoAuth');
if (selectAdminSubNoAuth) {
    selectAdminSubNoAuth.addEventListener('change', (event) => {
        const customUrl = settingUrlForSelect();

        window.location.href = customUrl.path + '?pageNoAuth=' + customUrl.urlPageNoAuth
         + '&countNoAuth=' + event.target.value + '&pageAuth=' + customUrl.urlPageAuth + '&countAuth=' + customUrl.urlCountAuth;
    });
}
const selectAdminSubAuth = document.getElementById('adminRecordsSelectAuth');
if (selectAdminSubAuth) {
    selectAdminSubAuth.addEventListener('change', (event) => {
        const customUrl = settingUrlForSelect();

        window.location.href = customUrl.path + '?pageNoAuth=' + customUrl.urlPageNoAuth
         + '&countNoAuth=' + customUrl.urlCountNoAuth + '&pageAuth=' + customUrl.urlPageAuth + '&countAuth=' + event.target.value;
    });
}

/**-------- Отписка от рассылок ---------- */

    const formUnsubscribe = document.getElementById('formUnsubscribe');
    if (formUnsubscribe) {
        formUnsubscribe.addEventListener('submit', Unsubscribe);
    }

});

//функция формирует запрос на отписку
async function Unsubscribe() {
    event.preventDefault();
    const form = this;

    const response = await fetch('/request/unsubscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({email: document.getElementById('emailUnsubscribe').value}),
    });
    //получаем ответ
    const result = await response.json();
    console.log(result);
    //обработка ответа
    if (result.message) {
        form.textContent = 'Ошибка! ' + result.message;
    } else if (result.success) {
        form.textContent = 'Запрос выполнен успешно! ' + result.messageOk;
    } else {
        form.textContent = 'Ошибка! ' + result.error;
    }
}

//настройки гет параметров для строки url
function settingUrlForSelect() {
    const url = new URL(document.location);
    const searchParams = url.searchParams;
    let urlCountNoAuth = searchParams.get('countNoAuth');
    if (!urlCountNoAuth) {
        urlCountNoAuth = 20;
    }
    let urlCountAuth = searchParams.get('countAuth');
    if (!urlCountAuth) {
        urlCountAuth = 20;
    }
    let urlPageNoAuth = searchParams.get('pageNoAuth');
    if (!urlPageNoAuth) {
        urlPageNoAuth = 1;
    }
    let urlPageAuth = searchParams.get('pageAuth');
    if (!urlPageAuth) {
        urlPageAuth = 1;
    }
    const protocol = location.protocol + '//';
    const host = window.location.host;
    const pathname = window.location.pathname;
    const path = protocol + host + pathname; 

    return {
        path, urlCountNoAuth, urlCountAuth, urlPageNoAuth, urlPageAuth,
    }
}

//фунция размещает модальное окно в DOM
function eventShowModal(classPrefix, url, event) {
    //проверка на кнопку удаления
    const linkDelete = event.target.closest('.link-delete-' + classPrefix);
    if (!linkDelete) return;
    if (!linkDelete.contains(linkDelete)) return;
    
    //получаем id
    const id = linkDelete.getAttribute('data-bs-' + classPrefix);
    //получаем представление модального окна
    const modalDOM = createModal('modal');
    //размещаем в DOM
    document.body.append(modalDOM.popup);
    document.body.append(modalDOM.overlay);
    //делаем видимым
    modalDOM.popup.classList.add('open');
	modalDOM.overlay.classList.add('open');
    //если видим
    if (modal.classList.contains('open')) {
        //при клике по одному из перечисленных классов скрываем модальное окно
        document.body.addEventListener('click', (event) => {
            eventCloseModal('.overlay', modalDOM.popup, modalDOM.overlay, event);
            eventCloseModal('.popup-close', modalDOM.popup, modalDOM.overlay, event);
            eventCloseModal('.btn-cancel-modal', modalDOM.popup, modalDOM.overlay, event);
        })
    }
    //отправляем id в открытое модальное окно
    showTextModal(modalDOM.popup, id, url, classPrefix);
}
/**
 * проверка по тому ли классу происходит событие
 * @param {string} className 
 * @param {HTMLBaseElement} modal 
 * @param {HTMLBaseElement} overlay 
 * @param {event} event 
 * @returns 
 */
function eventCloseModal(className, modal, overlay, event) {
    const selector = event.target.closest(className);
    if (!selector) return;
    if (!selector.contains(selector)) return;
    //уничтадаем модальное окно
    destroyModal(modal, overlay);
}
/**
 * функция удаляет модальное окно
 * @param {HTMLBaseElement} modal 
 * @param {HTMLBaseElement} overlay 
 */
function destroyModal(modal, overlay) {
    modal.classList.remove('open');
    overlay.classList.remove('open');
    modal.remove();
    overlay.remove();
}
/**
 * функция меняет текст в модальном окне и размещает событие на кнопку подтверждения удаления
 * @param {HTMLBaseElement} modal 
 * @param {int} id 
 *  @param {string} url 
 *  @param {string} classPrefix 
 */
function showTextModal(modal, id, url, classPrefix) {
    const modalBody = modal.querySelector('.modal-body');
    //текст модального окна  
    modalBody.textContent = 'Вы действительно хотите удалить данную запись с id=' + id + ' из базы данных?';
    //событие удаления записи
    modal.addEventListener('click',  (event) => deleteObj(modal, id, url, classPrefix, event));
}
/**
 * функция отправляет id записи на сервер для удаления из БД
 * @param {HTMLBaseElement} modal 
 * @param {int} id 
 * @param {string} url 
 * @param {string} classPrefix 
 * @param {event} event 
 * @returns 
 */
async function deleteObj(modal, id, url, classPrefix, event) {
    //проверяем нажата ли кнопка удаления
    const btnDelete = event.target.closest('.btn-delete-modal');
    if (!btnDelete) return;
    if (!btnDelete.contains(btnDelete)) return;

    //отправляем на сервер
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({ id: id}),
    });
    //получаем ответ
    const result = await response.json();
    //удаляем модальное окно
    destroyModal(modal, document.querySelector('.overlay'));
    //обработка ответа
    showServerResponseDelete(result, classPrefix);
}    
/**
 * Обработка ответа от сервера
 * @param {object} result 
 * @param {string} classPrefix 
 */
function showServerResponseDelete(result, classPrefix) {
    if (result.success) {
        messageWarning('Отлично!', result.successMessage);
        //тут перерисовка таблицы
        const table = createTable(result.header, result.body, classPrefix);
        document.querySelector('.table-' + classPrefix + 's').remove();
        document.querySelector('.wrapper-table-' + classPrefix + 's').prepend(table);
        defaultActivePagePaginator();
    } else {
        messageWarning('Ошибка!', result.error);
    }
}

/**
 * делаем активным первую страницу пагинации, если она есть
 */
function defaultActivePagePaginator() {
    const wrapPaginator = document.querySelector('.nav-pagination');
    if (wrapPaginator) {
        const list = wrapPaginator.querySelectorAll('.page-item');
        list.forEach(item => {
            if (item.classList.contains('active')) {
                item.classList.remove('active');
            }
        });
        list[1].classList.add('active');
    }
}

/**
 * Создаем таблицу 
 * @param {array} header 
 * @param {object} body 
 * @param {string} classPrefix 
 */
function createTable(header, body, classPrefix)
{
    const table = document.createElement('table');
    table.classList.add(
        'table', 
        'table-striped',
        'table-hover',
        'table-' + classPrefix + 's'
    );
    const thead = document.createElement('thead');
    const trHead = document.createElement('tr');
    //названия полей
    const names = header;
    names.forEach(name => {
        let th = document.createElement('th');
        th.setAttribute('scope', 'col');
        th.textContent = name;
        trHead.append(th);
    });
    thead.append(trHead);

    const tbody = document.createElement('tbody');

    for (const key in body) {
        const trBody = document.createElement('tr');

        //тут определяем к какой модели относится таблица
        const fields = bodySelection(classPrefix, key, body);

        const tdChange = document.createElement('td');
        const linkChange = document.createElement('a');
        linkChange.href = '/admin/' + classPrefix + 's/' + key;    
        const imgChange = document.createElement('img');
        imgChange.src = '/img/users/change.png';
        imgChange.width = '20';
        imgChange.alt = 'Редактировать';
        linkChange.append(imgChange);
        tdChange.append(linkChange);
            
        const tdDelete = document.createElement('td');
        const linkDelete = document.createElement('a');
        linkDelete.classList.add('link-delete-' + classPrefix);
        linkDelete.href = '#';
        linkDelete.setAttribute('data-bs-' + classPrefix, key);
        const imgDelete = document.createElement('img');
        imgDelete.src = '/img/users/delete.png';
        imgDelete.width = '20';
        imgDelete.alt = 'Удалить';
        linkDelete.append(imgDelete);
        tdDelete.append(linkDelete);
        
        fields.forEach(field => {
            trBody.append(field);
        });

        if (classPrefix != 'no-auth-subscription' || classPrefix != 'auth-subscription') {
            trBody.append(tdChange);    
        }

        trBody.append(tdDelete);
        tbody.append(trBody);
    }
 
    table.append(thead, tbody);
    
    return table;
}

/**
 * функция выбирает какое тело таблицы должно быть
 * @param {string} classPrefix 
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
function bodySelection(classPrefix, key, body) {
    switch (classPrefix) {
        case 'user':
            return createBodyUsers(key, body);
        case 'post':
            return createBodyPosts(key, body);
        case 'no-auth-subscription':
            return createBodySubscr(key, body);
        case 'auth-subscription':
            return createBodySubscr(key, body);
        case 'comment':
            return createBodyComments(key, body);
        case 'page':
            return createBodyPages(key, body);
        default:
            break;
    }
}

/**
 * создаем поля пользователей
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
function createBodyUsers(key, body) {

    const thId = document.createElement('th');
    thId.setAttribute('scope', 'row');
    thId.textContent = key;

    const tdName = document.createElement('td');
    tdName.textContent = body[key].full_name;

    const tdEmail = document.createElement('td');
    tdEmail.textContent = body[key].email;

    const tdGroup = document.createElement('td');
    tdGroup.textContent = body[key].group;

    const tdSubscr = document.createElement('td');
    tdSubscr.textContent = body[key].subscription;

    return [
        thId,
        tdName,
        tdEmail,
        tdGroup,
        tdSubscr
    ]
}

/**
 * создаем поля статей
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
 function createBodyPosts(key, body) {

    const thId = document.createElement('th');
    thId.setAttribute('scope', 'row');
    thId.textContent = key;

    const tdName = document.createElement('td');
    tdName.textContent = body[key].full_name;

    const tdDesc = document.createElement('td');
    tdDesc.textContent = body[key].description;

    const tdDate = document.createElement('td');
    tdDate.textContent = body[key].date;

    return [
        thId,
        tdName,
        tdDesc,
        tdDate
    ]
}

/**
 * создаем поля подписки
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
 function createBodySubscr(key, body) {

    const thId = document.createElement('th');
    thId.setAttribute('scope', 'row');
    thId.textContent = key;

    const tdEmail = document.createElement('td');
    tdEmail.textContent = body[key].email;

    return [
        thId,
        tdEmail,
    ]
}

/**
 * создаем поля комментариев
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
 function createBodyComments(key, body) {

    const thId = document.createElement('th');
    thId.setAttribute('scope', 'row');
    thId.textContent = key;

    const tdText = document.createElement('td');
    tdText.textContent = body[key].text;

    const tdPost = document.createElement('td');
    tdPost.textContent = body[key].post;

    const tdEmail = document.createElement('td');
    tdEmail.textContent = body[key].email;

    const tdCheck = document.createElement('td');
    tdCheck.textContent = body[key].is_check;

    return [
        thId,
        tdText,
        tdPost,
        tdEmail,
        tdCheck
    ]
}

/**
 * создаем поля страниц
 * @param {int} key 
 * @param {object} body 
 * @returns 
 */
 function createBodyPages(key, body) {

    const thId = document.createElement('th');
    thId.setAttribute('scope', 'row');
    thId.textContent = key;

    const tdTitile = document.createElement('td');
    tdTitile.textContent = body[key].title;

    const tdSlug = document.createElement('td');
    tdSlug.textContent = body[key].slug;

    return [
        thId,
        tdTitile,
        tdSlug,
    ]
}

/**
 * 
 * @param {string} idModal 
 * @returns 
 */
function createModal(idModal) {
    const popup = document.createElement('div');
    popup.classList.add(
        'modal-dialog', 
        'modal-dialog-centered',
        'popup'
    );
    popup.id = idModal;
    
    const content = document.createElement('div');
    content.classList.add('modal-content');

    const header = document.createElement('div');
    header.classList.add('modal-header');

    const title = document.createElement('h5');
    content.classList.add('modal-title');
    title.id = 'modalLabel';
    title.textContent = 'Удаление записи';

    const btnClose = document.createElement('button');
    btnClose.classList.add('btn-close', 'popup-close');

    header.append(title, btnClose);

    const body = document.createElement('div');
    body.classList.add('modal-body');
    body.textContent = 'Вы действительно хотите удалить данную запись из базы данных?';

    const footer = document.createElement('div');
    footer.classList.add('modal-footer');

    const btnCancel = document.createElement('button');
    btnCancel.classList.add('btn', 'btn-secondary', 'btn-cancel-modal');
    btnCancel.textContent = 'Отмена';

    const btnDelete = document.createElement('button');
    btnDelete.classList.add('btn', 'btn-danger', 'btn-delete-modal');
    btnDelete.textContent = 'Удалить';

    footer.append(btnCancel, btnDelete);

    content.append(header, body, footer);

    popup.append(content);

    const overlay = document.createElement('div');
    overlay.classList.add('overlay');

    return {
        popup,
        overlay
    }
}

//функция срабатывает на всех кнопках с заданным классом
async function eventBtnComment(className, box, event) {
    const btn = event.target.closest(className);
    if (!btn) return;
    if (!box.contains(btn)) return;
    
    //получаем id статьи из url
    const pathname = document.location.pathname;
    const fields = pathname.split('/');
    const idPost = fields[2];
    
    //получаем id комментария
    const id = btn.closest('.comment').id;
    //отправляем на сервер
    const response = await fetch('/request/moderationComment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            idComment: id,
            btn: className,
            postId: idPost
        }),
    });

    //получаем ответ
    const result = await response.json();
    //обработка ответа
    showServerResponse(result, result.successMessage, true);
}

//функция для отправки комментария на сервер, получает ответ в виде json
//тут применяем fetch 
async function addComment() {
    event.preventDefault();
    //получаем id пользователя, который оставил комментарий из сессии
    const userId = document.getElementById('userComment').value;
    //если пользователь неавторизированный 
    if (!userId) {
        messageWarning();
    //иначе пользователь авторизован
    } else {
        const data = {
            comment: document.querySelector('.comment-textarea').value,
            userId: userId,
            postId: document.getElementById('postId').value,
            groupId: document.getElementById('groupId').value,
        };
        const response = await fetch('/request/comment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
        });
        //получаем ответ
        const result = await response.json();
        //обработка ответа
        showServerResponse(result, 'Ваш комментарий добавлен.', false, userId);
    }
}
//фунцкия обрабатывает ответы сервера
/**
 * 
 * @param {array} result - массив объектов
 * @param {string} messageComment - сообщение пользователю
 * @param {bool} isAdmin - флаг для админа
 * @param {int} userId - идентификатор пользователя
 */
function showServerResponse(result, messageComment, isAdmin = false, userId) {
    if (result.message) {
        messageWarning('Ошибка!', result.message);
    } else if (result.success) {
        messageWarning('Отлично!', messageComment);
        //тут перерисовка блока с комментариями
        getListComments(result.comments, isAdmin, userId);

    } else {
        messageWarning('Ошибка!', result.error);
    }
}
//функция обновляет блок с новыми комментариями
function getListComments(comments, isAdmin, userId) {
    let box = document.querySelector('.comments-box');
    box.innerHTML = '';
    comments.forEach(comment => {
        box.append(createComment(comment.user, comment, isAdmin, userId));
    });
}
//создание комментария
/**
 * 
 * @param {object} user - объект с свойствами пользователя
 * @param {object} comment - объект с свойствами комментария
 * @param {bool} isAdmin - флаг для админа
 * @param {int} userId - идентификатор пользователя
 * @returns 
 */
function createComment(user, comment, isAdmin, userId) {
    const wrapper = document.createElement('div');
    wrapper.classList.add('d-flex', 'mb-3', 'p-3', 'bg-light', 'comment');
    wrapper.id = comment.id;

    const boxImg = document.createElement('div');
    boxImg.classList.add('text-center');

    const img = document.createElement('img');
    img.classList.add('me-3', 'rounded-circle');
    img.src = "/img/users/" + user.avatar;
    img.alt = user.full_name;
    img.width = '100';
    img.height = '100';

    const title = document.createElement('h6');
    title.classList.add('mt-1', 'mb-0', 'me-3');
    title.textContent = user.full_name;

    boxImg.append(img, title);

    const boxText = document.createElement('div');
    boxText.classList.add('flex-grow-1', 'd-block');

    const article = document.createElement('p');
    article.classList.add('mt-3', 'mb-2');
    article.textContent = comment.text;

    const time = document.createElement('time');
    time.classList.add('timeago', 'text-muted');
    time.dateTime = comment.date;
    time.textContent = comment.date;

    if ((userId == user.id && comment.is_check == 0) || (isAdmin == true && comment.is_check == 0)) {
        const span = document.createElement('span');
        span.classList.add('moderation');
        span.textContent = 'На модерации';
        time.append(span)
        if (isAdmin == true && comment.is_check == 0) {
            const wrapBtn = document.createElement('div');
            const btnAppr = document.createElement('button');
            btnAppr.classList.add('btn', 'btn-outline-success', 'approveComment');
            btnAppr.textContent = 'Утвердить';
            const btnReject = document.createElement('button');
            btnReject.classList.add('btn', 'btn-outline-danger', 'rejectComment');
            btnReject.textContent = 'Отклонить';
            
            wrapBtn.append(btnAppr, btnReject);
            time.append(wrapBtn);
        }
    }
    
    boxText.append(article, time);

    wrapper.append(boxImg, boxText);

    return wrapper;
}

//функция показывает сообщение пользователю о его неавторизации и предлагает перейти на авторизацию/регистрацию
function messageWarning(header = null, body = null) {
    const toast = document.querySelector('.toast');
    if (toast.classList.contains('show')) {
        toast.classList.remove('show');
        toast.classList.add('hide');
    }
    toast.classList.remove('hide');
    toast.classList.add('show');

    if (header !== null && body !== null) {
        const toastHeader = document.querySelector('.me-auto');
        const toastBody = document.querySelector('.toast-body');
        toastHeader.innerHTML = '';
        toastBody.innerHTML = '';
        toastHeader.textContent = header;
        toastBody.textContent = body;
    }
}

//функция для отправки данных формы на сервер, получает ответ в виде json
//тут же применяем XMLHttpRequest, так же для практики другим способом
function subscription() {
    event.preventDefault();
    const thisForm = this;
    //создаем объект запроса
    const request = new XMLHttpRequest(), method = 'POST', url = "/request";
    //предаем в него метод и url
    request.open(method, url, true);
    //тип
    request.responseType = 'json';
    //создаем объект данных 
    const data = new FormData(this);
    //именнуем данные
    for (let key of data.keys());
    //отправляем данные
    request.send(data);
    // получаем ответ от сервера в виде объекта
    request.onload = function() {
        const responseObj = request.response;
        let containerMessage = document.createElement('div');
        if (responseObj.message) {
            containerMessage.classList.add('subscription-success')
            containerMessage.innerHTML = responseObj.message;
        } else {
            containerMessage.classList.add('subscription-error')
            containerMessage.innerHTML = responseObj.error;
        }
        thisForm.innerHTML = '';
        thisForm.append(containerMessage);
    };
    //ошибка
    request.onerror = function() {
        thisForm.innerHTML = 'Ошибка. Данные не отправлены';
    };   
}


//регулярка для имени
const patternFullName = /^[a-zA-Zа-яА-ЯёЁ'][a-zA-Z-а-яА-ЯёЁ' ][a-zA-Z-а-яА-ЯёЁ' ]+[a-zA-Zа-яА-ЯёЁ']?$/
//регулярка для email
const patternEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

//функция удаляет старое фото и показывает новое
function preloadImg(evt, cardBody, classNameImg) {
    const oldImg = cardBody.querySelector('img');
   
    const img = document.createElement('img');
    img.className = classNameImg;
    
    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
        img.src = evt.target.result;
        oldImg.remove();
        cardBody.prepend(img);
    };

    reader.readAsDataURL(file);
}

//функция валидации формы для изменения профиля
function validateProfile() {
    //отменяем отправку формы
    event.preventDefault();
    //удаляем все ошибки, если они были
    removeErrors('.error-login');
    //именуем константы
    const form = document.getElementById('formLk');
    const fullName = document.querySelector('input[name="name"]');
    const email = document.querySelector('input[name="email"]');

    //ошибка на email
    const errorEmail = errorChecking(patternEmail.test(email.value) == false, 'Введите правильный формат email!', email);
    //ошибка на имя
    const errorName = errorChecking(patternFullName.test(fullName.value) == false, 'Введите правильный формат Имени!', fullName);
    //если нет ошибок
    if (!errorEmail && !errorName) {
        removeErrors('.error');
        form.submit();
    }
}
//функция валидации формы регистрации
function validateReg() {
    //отменяем отправку формы
    event.preventDefault();
    //удаляем все ошибки, если они были
    removeErrors('.error-login');
    //именуем константы
    const form = document.getElementById('formReg');
    const fullName = document.querySelector('input[name="fullName"]');
    const email = document.querySelector('input[name="newEmail"]');
    const password = document.querySelector('input[name="newPassword"]');
    const password2 = document.querySelector('input[name="newPassword2"]');
    const checkbox = document.getElementById('checkbox');
    //ошибка на чекбокс принятия правил сайта
    const errorChecked = errorChecking(checkbox.checked == false, 'Вы не приняли правила сайта!', document.querySelector('label'), true);
    //ошибка на повтор пароля
    const errorRepeatPassword = errorChecking(password.value !== password2.value, 'Подтверждение пароля не верно!', password2);
    //ошибка на пароль
    const errorPassord = errorChecking(password.value.length < 6, 'Пароль должен быть минимум 6 символов!', password);
    //ошибка на email
    const errorEmail = errorChecking(patternEmail.test(email.value) == false, 'Введите правильный формат email!', email);
    //ошибка на имя
    const errorName = errorChecking(patternFullName.test(fullName.value) == false, 'Введите правильный формат Имени!', fullName);
    //если нет ошибок
    if (!errorName && !errorEmail && !errorPassord && !errorRepeatPassword && !errorChecked) {
        removeErrors('.error');
        form.submit();
    }

}
//функция валидации формы авторизации
function validateAuth() {
    //отменяем отправку формы
    event.preventDefault();
    //удаляем все ошибки, если они были
    removeErrors('.error-login');
    //именуем константы
    const form = document.getElementById('formAuth');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    //ошибка на пароль
    const errorPassord = errorChecking(password.value.length < 6, 'Пароль должен быть минимум 6 символов!', password);
    //ошибка на email
    const errorEmail = errorChecking(patternEmail.test(email.value) == false, 'Введите правильный формат email!', email);
    //если нет ошибок
    if (!errorEmail && !errorPassord) {
        removeErrors('.error');
        form.submit();
    }
}
//функция проверки на условие ошибки
function errorChecking(condition, message, field, label) {
    if (condition) {
        //выводим ошибку
        showError(field, message, label);
        return true;
    }

    return false;
}
//функция вывода ошибки за полем селектора
function showError(selector, message, label = null) {
    removeErrors('.error');
    removeClassCss('error--input');
    const div = document.createElement('div');
    div.classList.add('error');
    if (label) div.classList.add('error-label');
    div.textContent = message;
    selector.after(div);
    //если селектор не лейбол
    if (label == null) {
        //добавляем класс ошибки
        selector.classList.add('error--input');
    }
}
//функция удаления выведенных ошибок
function removeErrors(className) {
    if (document.querySelectorAll(className).length) {
        document.querySelectorAll(className).forEach(function(item) {
            item.remove();
        });
    }
}
//функция удаления класса ошибок
function removeClassCss(className) {
    if (document.querySelectorAll("." + className).length) {
        document.querySelectorAll("." + className).forEach(function(item) {
            item.classList.remove(className);
        });
    }
}

