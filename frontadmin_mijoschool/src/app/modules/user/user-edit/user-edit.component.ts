import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { UserService } from '../service/user.service';
import { Toaster } from 'ngx-toast-notifications';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.scss']
})
export class UserEditComponent implements OnInit {
  @Input() user: any;
  @Output() useredit: EventEmitter<any> = new EventEmitter();
  name: any = null;
  lastname: any = null;
  email: any = null;
  username: any = null;
  role_id: any = null;
  state: any = null;
  IMAGE_PHOTO: any = null;
  FILE_PHOTO: any = 'null';
  isLoading: any;
  constructor(
    public userservice: UserService,
    public toaster: Toaster,
    public modal: NgbActiveModal
  ) { }

  ngOnInit(): void {
    this.isLoading = this.userservice.isLoading$;
    this.name = this.user.name;
    this.lastname = this.user.lastname;
    this.email = this.user.email;
    this.username = this.user.username;
    this.role_id = this.user.role.id;
    this.state = this.user.state;
    this.IMAGE_PHOTO = this.user.profile_photo_path;

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
    if (!this.name || !this.lastname || !this.email || !this.username || !this.role_id || this.state == null) {
      this.toaster.open({ text: "Todos los campos son obligatorios", caption: "CUIDADO", type: 'danger' })
      return;
    }
    let formdata = new FormData();
    formdata.append("name", this.name);
    formdata.append("lastname", this.lastname);
    formdata.append("email", this.email);
    formdata.append("username", this.username);
    if (this.role_id == 1) {
      formdata.append("type_user", "1");
    } else {
      formdata.append("type_user", "2");
    }
    formdata.append("state", this.state);
    formdata.append("role_id", this.role_id);
    formdata.append("imagen", this.FILE_PHOTO);

    this.userservice.update(formdata, this.user.id).subscribe((resp: any) => {
      this.useredit.emit(resp.user);
      this.toaster.open({ text: "Usuario Actualizado Exitosamente", caption: "Success", type: 'primary' });
      this.modal.close();
      console.log(resp);
    })

  }

}
