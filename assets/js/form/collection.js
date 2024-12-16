(function () {
    'use strict';

    const Collections = {
        config: {
            selector: '[data-formtype="collection"]',
            lang: {
                en: {
                    add: 'Add',
                    remove: 'Remove',
                }
            },
        },
        initialize: function () {
            const collectionElements = document.querySelectorAll(this.config.selector)
            if (!collectionElements.length) {
                return;
            }
            collectionElements.forEach(collectionElement => {
                this.setup(collectionElement)
            });
        },
        setup: function (collectionElement) {
            collectionElement.setAttribute(
                'data-entry-index',
                collectionElement.children.length
            )
            if (collectionElement.getAttribute('data-allow-add') === "1") {
                this.appendEntryAddButton(collectionElement);
            }
            this.refresh(collectionElement);
            collectionElement.addEventListener('click', function (event) {
                Collections.configureCollectionElement(event);
            });
        },
        appendEntryAddButton: function (collectionElement) {
            const button = this.generateButton(
                'add',
                this.config.lang.en.add,
                'secondary'
            );
            collectionElement.appendChild(button);
        },
        appendEntryRemoveButton: function (collectionElement) {
            const button = this.generateButton(
                'remove',
                this.config.lang.en.remove,
                'secondary'
            );
            [...collectionElement.children]
                .filter(function(entryElement) {
                    if (!entryElement.classList.contains('form-group')) {
                        return false;
                    }
                    const hasRemove =  [...entryElement.children]
                        .filter(entry => entry.hasAttribute('data-entry-action'))
                        .length;
                    if (hasRemove) {
                        return false;
                    }
                    return true;
                })
                .forEach(entryElement => {
                    entryElement.appendChild(button.cloneNode(true))
                });
        },
        addEntry: function (entryAddButton) {
            const collectionElement = entryAddButton.parentElement;
            const entryIndex = collectionElement.getAttribute('data-entry-index');
            collectionElement.setAttribute('data-entry-index', +entryIndex + 1);
            const entryPrototype = collectionElement.getAttribute('data-prototype');
            const templateContent = this.getTemplateContent(entryPrototype, entryIndex);
            entryAddButton.parentElement.insertBefore(templateContent, entryAddButton);
            this.refresh(collectionElement);

            const event = new CustomEvent('entry-added', {detail: entryAddButton.previousElementSibling});
            entryAddButton.parentElement.dispatchEvent(event);
        },
        removeEntry: function (entryRemoveButton) {
            const collectionElement = entryRemoveButton.parentElement.parentElement;
            const entryToRemove = entryRemoveButton.parentElement;
            const parentElement = entryToRemove.parentElement;
            entryToRemove.remove();
            this.refresh(collectionElement);
        },
        refresh: function(collectionElement) {
            if (collectionElement.getAttribute('data-allow-remove') === "1") {
                this.appendEntryRemoveButton(collectionElement);
            }
        },
        configureCollectionElement: function (event) {
            if (!event.target.hasAttribute('data-entry-action')) {
                return;
            }
            switch (event.target.getAttribute('data-entry-action')) {
                case 'add':
                    this.addEntry(event.target);
                    break;
                case 'remove':
                    this.removeEntry(event.target);
                    break;
            }
        },
        generateButton: function (buttonAction, buttonLabel, buttonClass) {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = buttonLabel;
            button.className = 'btn btn-sm btn-' + buttonClass;
            button.dataset.entryAction = buttonAction
            return button
        },
        getTemplateContent: function (entryPrototype, entryIndex) {
            const template = document.createElement('template')
            const entryHtml = entryPrototype
                .replace(/__name__label__/g, `<span class="badge bg-success">New</span> ${entryIndex}`)
                .replace(/__name__/g, entryIndex)
            template.innerHTML = entryHtml.trim()
            return template.content
        }
    }

    Collections.initialize();

})();
