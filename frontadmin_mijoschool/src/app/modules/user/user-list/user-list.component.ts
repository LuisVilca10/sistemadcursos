import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { UserComponent } from '../user.component';
import { UserAddComponent } from '../user-add/user-add.component';
import { UserService } from '../service/user.service';
import { UserEditComponent } from '../user-edit/user-edit.component';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class UserListComponent implements OnInit {
  users: any = [];
  isLoading: any = null;
  search: any = null;
  state: any = null;
  role: any = null;
  constructor(
    public modalservice: NgbModal,
    public userservice: UserService
  ) { }

  ngOnInit(): void {
    this.isLoading = this.userservice.isLoading$;
    this.listUser();
  }
  listUser() {
    this.userservice.listUser(this.search, this.state, this.role).subscribe((resp: any) => {
      this.users = resp.users.data;
      console.log(resp)
    })
  }
  openModalCreateUser() {
    const modalRef = this.modalservice.open(UserAddComponent, { centered: true, size: 'lg' });
    modalRef.componentInstance.useradd.subscribe((resp: any) => {
      this.users.unshift(resp);
    })
  }
  onEdit(user: any) {
    const modalRef = this.modalservice.open(UserEditComponent, { centered: true, size: 'lg' });
    modalRef.componentInstance.user = user;
    modalRef.componentInstance.useredit.subscribe((resp: any) => {
      let INDEX = this.users.findIndex((item: any) => item.id == user.id);
      this.users[INDEX] = resp;
    })
  }
  onDelete(id: any) {
    console.log(id)
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Esta acción no se puede deshacer",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        this.userservice.delete(id).subscribe({
          next: () => {
            this.users = this.users.filter((user: any) => user.id !== id);
            Swal.fire("Eliminado", "El registro ha sido eliminado.", "success");
          },
          error: (err) => {
            console.error("Error al eliminar el usuario:", err);
            Swal.fire("Error", "No se pudo eliminar el usuario.", "error");
          }
        });
      }
    });

  }

}
