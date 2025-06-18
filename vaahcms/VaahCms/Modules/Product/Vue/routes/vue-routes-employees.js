let routes= [];
let routes_list= [];

import List from '../pages/employees/List.vue'
import Form from '../pages/employees/Form.vue'
import Item from '../pages/employees/Item.vue'
import Filters from '../pages/employees/Filters.vue'

routes_list = {

    path: '/employees',
    name: 'employees.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'employees.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'employees.view',
            component: Item,
            props: true,
        },
        {
            path: 'filters',
            name: 'employees.filters',
            component: Filters,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

