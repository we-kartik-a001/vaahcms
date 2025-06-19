let routes= [];
let routes_list= [];

import List from '../pages/persons/List.vue'
import Form from '../pages/persons/Form.vue'
import Item from '../pages/persons/Item.vue'
import Filters from '../pages/persons/Filters.vue'

routes_list = {

    path: '/persons',
    name: 'persons.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'persons.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'persons.view',
            component: Item,
            props: true,
        },
        {
            path: 'filters',
            name: 'persons.filters',
            component: Filters,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

