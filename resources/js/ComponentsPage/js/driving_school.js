//os components abaixo pertencem a lógica de acesso 'users'
import Create from '@/ComponentsPage/DrivingSchool/Vehicles/Create.vue';
import List from '@/ComponentsPage/DrivingSchool/Vehicles/List.vue';
import Edit from '@/ComponentsPage/DrivingSchool/Vehicles/Edit.vue';
//students
import StudentCreate from '@/ComponentsPage/DrivingSchool/Students/Create.vue';
import StudentList from '@/ComponentsPage/DrivingSchool/Students/List.vue';

const vehicles = {
     Create,
     List,
     Edit
};
const students = {
    StudentCreate,
    StudentList
};
export{
    vehicles,
    students
}
