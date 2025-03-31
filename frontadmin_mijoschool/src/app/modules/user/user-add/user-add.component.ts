import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';
import { Toaster } from 'ngx-toast-notifications';
import { UserService } from '../service/user.service';

@Component({
  selector: 'app-user-add',
  templateUrl: './user-add.component.html',
  styleUrls: ['./user-add.component.scss']
})
export class UserAddComponent implements OnInit {
  @Output() useradd: EventEmitter<any> = new EventEmitter();
  name: any = null;
  lastname: any = null;
  email: any = null;
  username: any = null;
  password: any = null;
  password_confirmation: any = null;
  role_id: any = null;
  IMAGE_PHOTO: any = null;
  FILE_PHOTO: any = 'null';
  state: any = null;
  isLoading: any;
  constructor(
    public userservice: UserService,
    public toaster: Toaster,
    public modal: NgbActiveModal
  ) { }

  ngOnInit(): void {
    this.isLoading = this.userservice.isLoading$;
  }
  processphoto($event: any) {
    if ($event.target.files[0].type.indexOf("image") < 0) {
      this.toaster.open({ text: "Solo se aceptan imagenes", caption: "CUIDADO", type: 'danger' })
      return;
    }
    this.FILE_PHOTO = $event.target.files[0];
    let reader = new FileReader();
    reader.readAsDataURL($event.target.files[0]);
    reader.onloadend = () => this.IMAGE_PHOTO = reader.result;

  }

  store() {
    if (!this.name || !this.lastname || !this.email || !this.username || !this.password || !this.password_confirmation || !this.state) {
      this.toaster.open({ text: "Todos los campos son obligatorios", caption: "CUIDADO", type: 'danger' })
      return;
    }
    if (this.password != this.password_confirmation) {
      this.toaster.open({ text: "Las contraseñas no coinciden", caption: "CUIDADO", type: 'danger' })
      return;
    }
    let formdata = new FormData();
    formdata.append("name", this.name);
    formdata.append("lastname", this.lastname);
    formdata.append("email", this.email);
    formdata.append("username", this.username);
    formdata.append("password", this.password);
    formdata.append("password_confirmation", this.password_confirmation);
    if (this.role_id == 1) {
      formdata.append("type_user", "1");
    } else {
      formdata.append("type_user", "2");
    }
    formdata.append("state", this.state);
    formdata.append("role_id", this.role_id);
    formdata.append("imagen", this.FILE_PHOTO);

    this.userservice.register(formdata).subscribe((resp: any) => {
      this.useradd.emit(resp.user);
      this.toaster.open({ text: "Usuario Creado Exitosamente", caption: "Success", type: 'primary' });
      this.modal.close();
      console.log(resp);
    })

  }
}
