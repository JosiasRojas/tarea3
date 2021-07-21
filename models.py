from datetime import datetime
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class Pais(db.Model):
    __tablename__ = 'pais'
    cod_pais = db.Column(db.Integer, primary_key=True)
    nombre = db.Column(db.String(45),nullable=False)

    @classmethod
    def create(cls, cod_pais, nombre):
        pais = Pais(cod_pais=cod_pais, nombre=nombre)
        return pais.save()

    def save(self):
        try:
            
            db.session.add(self)
            db.session.commit()
            return self
        except:
            return False

    def json(self):
        return {
            'cod_pais':self.cod_pais,
            'nombre': self.nombre
        }

    def update(self):
        self.save()

    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False

class Usuario(db.Model):
    __tablename__ = 'usuario'
    id = db.Column(db.Integer, primary_key=True)
    nombre = db.Column(db.String(50),nullable=False)
    apellido = db.Column(db.String(50))
    correo = db.Column(db.String(50),nullable=False)
    contraseña = db.Column(db.String(50),nullable=False)
    pais = db.Column(db.Integer, db.ForeignKey('pais.cod_pais'),nullable=False)
    fecha_registro = db.Column(db.DateTime, default=db.func.current_timestamp(),nullable=False)

    @classmethod
    def create(cls, nombre, apellido,correo,contraseña,pais):
        usuario = Usuario(nombre=nombre,apellido=apellido, correo=correo, contraseña=contraseña, pais=pais)
        return usuario.save()

    def save(self):
        try:
            db.session.add(self)
            db.session.commit()

            return self
        except:
            return False

    def json(self):
        return {
            'id':self.id,
            'nombre': self.nombre,
            'apellido': self.apellido,
            'correo': self.correo,
            'contraseña': self.contraseña,
            'pais': self.pais,
            'fecha_registro': self.fecha_registro,
        }

    def update(self):
        self.save()
        
    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False

class CuentaBancaria(db.Model):
    __tablename__ = 'cuenta_bancaria'
    numero_cuenta = db.Column(db.Integer, primary_key=True)
    id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), nullable=False)
    balance = db.Column(db.Float, nullable=False)

    @classmethod
    def create(cls, id_usuario, balance):
        cuenta_bancaria = CuentaBancaria(id_usuario=id_usuario,balance=balance)
        return cuenta_bancaria.save()

    def save(self):
        try:
            db.session.add(self)
            db.session.commit()

            return self
        except:
            return False

    def json(self):
        return {
            'numero_cuenta':self.numero_cuenta,
            'id_usuario': self.id_usuario,
            'balance': self.balance,
        }

    def update(self):
        self.save()
        
    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False

class UsuarioTieneMoneda(db.Model):
    __tablename__ = 'usuario_tiene_moneda'
    id_usuario = db.Column(db.Integer, db.ForeignKey('usuario.id'), primary_key=True)
    id_moneda = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True)
    balance = db.Column(db.Float, nullable=False)

    @classmethod
    def create(cls, id_usuario, id_moneda, balance):
        usuario_tiene_moneda = UsuarioTieneMoneda(id_usuario=id_usuario,id_moneda=id_moneda,balance=balance)
        return usuario_tiene_moneda.save()

    def save(self):
        try:
            db.session.add(self)
            db.session.commit()

            return self
        except:
            return False

    def json(self):
        return {
            'id_usuario':self.id_usuario,
            'id_moneda': self.id_moneda,
            'balance': self.balance,
        }

    def update(self):
        self.save()
        
    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False

class Moneda(db.Model):
    __tablename__ = 'moneda'
    id = db.Column(db.Integer, primary_key=True)
    sigla = db.Column(db.String(10),nullable=False)
    nombre = db.Column(db.String(80),nullable=False)

    @classmethod
    def create(cls, sigla, nombre):
        moneda = Moneda(sigla=sigla,nombre=nombre)
        return moneda.save()

    def save(self):
        try:
            db.session.add(self)
            db.session.commit()

            return self
        except:
            return False

    def json(self):
        return {
            'id':self.id,
            'sigla': self.sigla,
            'nombre': self.nombre,
        }

    def update(self):
        self.save()
        
    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False

class PrecioMoneda(db.Model):
    __tablename__ = 'precio_moneda'
    id_moneda = db.Column(db.Integer, db.ForeignKey('moneda.id'), primary_key=True)
    fecha = db.Column(db.DateTime, default=db.func.current_timestamp() , primary_key=True)
    valor = db.Column(db.Float, nullable=False)

    @classmethod
    def create(cls, id_moneda, valor):
        precio_moneda = PrecioMoneda(id_moneda=id_moneda,valor=valor)
        return precio_moneda.save()

    def save(self):
        try:
            db.session.add(self)
            db.session.commit()

            return self
        except:
            return False

    def json(self):
        return {
            'id_moneda':self.id_moneda,
            'fecha': self.fecha,
            'valor': self.valor,
        }

    def update(self):
        self.save()
        
    def delete(self):
        try:
            db.session.delete(self)
            db.session.commit()

            return True
        except:
            return False