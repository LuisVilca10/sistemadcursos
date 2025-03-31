import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CategoriesComponent } from './categories.component';
import { CategoriesListComponent } from './categories-list/categories-list.component';
import { CategoriesAddComponent } from './categories-add/categories-add.component';
import { CategoriesEditComponent } from './categories-edit/categories-edit.component';

const routes: Routes = [
  {
    path: '',
    component: CategoriesComponent,
    children:[
      {
        path: 'list',
        component: CategoriesListComponent,
      },
      {
        path: 'add',
        component: CategoriesAddComponent
      },
      {
        path: 'edit',
        component: CategoriesEditComponent
      },
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CategoriesRoutingModule { }
