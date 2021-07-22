from flask import Flask
from flask import jsonify
from config import config
from models import Pais, CuentaBancaria, Moneda, PrecioMoneda, UsuarioTieneMoneda, Usuario
from models import db
from flask import request
import datetime
from sqlalchemy import func

def create_app(enviroment):
	app = Flask(__name__)
	app.config.from_object(enviroment)
	with app.app_context():
		db.init_app(app)
		db.create_all()
	return app

# Accedemos a la clase config del archivo config.py
enviroment = config['development']
app = create_app(enviroment)

# ========== Pais ============

# Create
@app.route('/api/pais', methods=['POST'])
def create_pais():
	json = request.get_json(force=True)

	if json.get('cod_pais') is None or json.get('nombre') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	pais = Pais.create(json['cod_pais'],json['nombre'])

	return jsonify({'pais': pais.json()})

# Read
@app.route('/api/pais', methods=['GET'])
def get_paises():
	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None:
			paises = [ pais.json() for pais in Pais.query.all()]
		else:
			paises = Pais.query.filter_by(cod_pais=json['id']).first().json()
	else:
		paises = [ pais.json() for pais in Pais.query.all()]
	return jsonify({'pais': paises})

# Update
@app.route('/api/pais/<cod_pais>', methods=['PUT'])
def update_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'message': 'Pais does not exists'}), 404
	
	json = request.get_json(force=True)
	if json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	pais.nombre = json['nombre']
	pais.update()

	return jsonify({'pais': pais.json()})

# Delete
@app.route('/api/pais/<cod_pais>', methods=['DELETE'])
def delete_pais(cod_pais):
	pais = Pais.query.filter_by(cod_pais=cod_pais).first()
	if pais is None:
		return jsonify({'message': 'Pais does not exists'}), 404

	pais.delete()

	return jsonify({'pais': pais.json() })

# ========== Cuenta Bancaria ============

# Create
@app.route('/api/cuenta_bancaria', methods=['POST'])
def create_cuenta_bancaria():
	json = request.get_json(force=True)

	if json.get('id_usuario') is None or json.get('balance') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	cuenta_bancaria = CuentaBancaria.create(json['id_usuario'],json['balance'])

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json()})

# Read
@app.route('/api/cuenta_bancaria', methods=['GET'])
def get_cuenta_bancaria():
	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None:
			cuentas_bancarias = [ cuenta_bancaria.json() for cuenta_bancaria in CuentaBancaria.query.all()]
		else:
			cuentas_bancarias = CuentaBancaria.query.filter_by(numero_cuenta=json['id']).first().json()
	else:
		cuentas_bancarias = [ cuenta_bancaria.json() for cuenta_bancaria in CuentaBancaria.query.all()]
	return jsonify({'cuenta_bancaria': cuentas_bancarias})

# Update
@app.route('/api/cuenta_bancaria/<numero_cuenta>', methods=['PUT'])
def update_cuenta_bancaria(numero_cuenta):
	cuenta_bancaria = CuentaBancaria.query.filter_by(numero_cuenta=numero_cuenta).first()
	if cuenta_bancaria is None:
		return jsonify({'message': 'Cuenta bancaria does not exists'}), 404
	
	json = request.get_json(force=True)
	if json.get('balance') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	cuenta_bancaria.balance = json['balance']
	cuenta_bancaria.update()

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json()})

# Delete
@app.route('/api/cuenta_bancaria/<numero_cuenta>', methods=['DELETE'])
def delete_cuenta_bancaria(numero_cuenta):
	cuenta_bancaria = CuentaBancaria.query.filter_by(numero_cuenta=numero_cuenta).first()
	if cuenta_bancaria is None:
		return jsonify({'message': 'Cuenta bancaria does not exists'}), 404

	cuenta_bancaria.delete()

	return jsonify({'cuenta_bancaria': cuenta_bancaria.json() })

# ========== Moneda ============

# Create
@app.route('/api/moneda', methods=['POST'])
def create_moneda():
	json = request.get_json(force=True)

	if json.get('sigla') is None or json.get('nombre') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	moneda = Moneda.create(json['sigla'],json['nombre'])

	return jsonify({'moneda': moneda.json()})

# Read
@app.route('/api/moneda', methods=['GET'])
def get_moneda():
	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None:
			monedas = [ moneda.json() for moneda in Moneda.query.all()]
		else:
			monedas = Moneda.query.filter_by(id=json['id']).first().json()
	else:
		monedas = [ moneda.json() for moneda in Moneda.query.all()]
	return jsonify({'moneda': monedas})

# Update
@app.route('/api/moneda/<id>', methods=['PUT'])
def update_moneda(id):
	moneda = Moneda.query.filter_by(id=id).first()
	if moneda is None:
		return jsonify({'message': 'Moneda does not exists'}), 404
	
	json = request.get_json(force=True)
	if json.get('sigla') is None or json.get('nombre') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	moneda.sigla = json['sigla']
	moneda.nombre = json['nombre']
	moneda.update()

	return jsonify({'moneda': moneda.json()})

# Delete
@app.route('/api/moneda/<id>', methods=['DELETE'])
def delete_moneda(id):
	moneda = Moneda.query.filter_by(id=id).first()
	if moneda is None:
		return jsonify({'message': 'Moneda does not exists'}), 404

	moneda.delete()

	return jsonify({'moneda': moneda.json() })

# ========== Precio Moneda ============

# Create
@app.route('/api/precio_moneda', methods=['POST'])
def create_precio_moneda():
	json = request.get_json(force=True)

	if json.get('id_moneda') is None or json.get('valor') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	precio_moneda = PrecioMoneda.create(json['id_moneda'],json['valor'])

	return jsonify({'precio_moneda': precio_moneda.json()})

# Read
@app.route('/api/precio_moneda', methods=['GET'])
def get_precio_moneda():
	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None or json.get('fecha') is None:
			precios_monedas = [ precio_moneda.json() for precio_moneda in PrecioMoneda.query.all()]
		

		fecha = datetime.datetime.strptime(json['fecha'],"%a, %d %b %Y %H:%M:%S GMT")
		menor = fecha - datetime.timedelta(seconds=0.5)
		mayor = fecha + datetime.timedelta(seconds=0.5)

		precios_monedas = PrecioMoneda.query.filter(PrecioMoneda.fecha.between(menor,mayor)).filter(PrecioMoneda.id_moneda==json['id']).first()
		# precios_monedas = PrecioMoneda.query.filter(func.date(PrecioMoneda.fecha) == fecha).all()

		print(precios_monedas)
		# precios_monedas = PrecioMoneda.query.filter_by(id_moneda=json['id'],fecha=fecha).first()
		if(precios_monedas):
			# precios_monedas = [ precio_moneda.json() for precio_moneda in precios_monedas]
			precios_monedas = precios_monedas.json()
	else:
		precios_monedas = [ precio_moneda.json() for precio_moneda in PrecioMoneda.query.all()]
	return jsonify({'precio_moneda': precios_monedas})

# Update
@app.route('/api/precio_moneda/<id_moneda>', methods=['PUT'])
def update_precio_moneda(id_moneda):
	json = request.get_json(force=True)
	if json.get('fecha') is None:
		return jsonify({'message': 'Bad request'}), 400
	

	fecha = datetime.datetime.strptime(json['fecha'],"%a, %d %b %Y %H:%M:%S GMT")
	menor = fecha - datetime.timedelta(seconds=0.5)
	mayor = fecha + datetime.timedelta(seconds=0.5)
	precio_moneda = PrecioMoneda.query.filter(PrecioMoneda.fecha.between(menor,mayor)).filter(PrecioMoneda.id_moneda==id_moneda).first()
	# precio_moneda = PrecioMoneda.query.filter_by(id_moneda=id_moneda,fecha=json['fecha']).first()
	if precio_moneda is None:
		return jsonify({'message': 'precio_moneda does not exists'}), 404
	
	if json.get('valor') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	precio_moneda.valor = json['valor']
	precio_moneda.update()

	return jsonify({'precio_moneda': precio_moneda.json()})

# Delete
@app.route('/api/precio_moneda/<id_moneda>', methods=['DELETE'])
def delete_precio_moneda(id_moneda):
	json = request.get_json(force=True)
	if json.get('fecha') is None:
		return jsonify({'message': 'Bad request'}), 400

	precio_moneda = PrecioMoneda.query.filter_by(id_moneda=id_moneda,fecha=json['fecha']).first()
	if precio_moneda is None:
		return jsonify({'message': 'Precio moneda does not exists'}), 404

	precio_moneda.delete()

	return jsonify({'precio_moneda': precio_moneda.json() })


# ========== Usuario Tiene Moneda ============

# Create
@app.route('/api/usuario_tiene_moneda', methods=['POST'])
def create_usuario_tiene_moneda():
	json = request.get_json(force=True)

	if json.get('id_usuario') is None or json.get('id_moneda') is None or json.get('balance') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	usuario_tiene_moneda = UsuarioTieneMoneda.create(json['id_usuario'],json['id_moneda'],json['balance'])

	return jsonify({'usuario_tiene_moneda': usuario_tiene_moneda.json()})

# Read
@app.route('/api/usuario_tiene_moneda', methods=['GET'])
def get_usuario_tiene_moneda():
	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None or json.get('id2') is None:
			usuarios_tienen_monedas = [ usuario_tiene_moneda.json() for usuario_tiene_moneda in UsuarioTieneMoneda.query.all()]
		else:
			usuarios_tienen_monedas = UsuarioTieneMoneda.query.filter_by(id_moneda=json['id'],id_usuario=json['id2']).first().json()
	else:
		usuarios_tienen_monedas = [ usuario_tiene_moneda.json() for usuario_tiene_moneda in UsuarioTieneMoneda.query.all()]

	# usuarios_tienen_monedas = [ usuario_tiene_moneda.json() for usuario_tiene_moneda in UsuarioTieneMoneda.query.all()]
	return jsonify({'usuario_tiene_moneda': usuarios_tienen_monedas})

# Update
@app.route('/api/usuario_tiene_moneda/<id_usuario>/<id_moneda>', methods=['PUT'])
def update_usuario_tiene_moneda(id_usuario,id_moneda):
	usuario_tiene_moneda = UsuarioTieneMoneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if usuario_tiene_moneda is None:
		return jsonify({'message': 'usuario_tiene_moneda does not exists'}), 404
	
	json = request.get_json(force=True)
	if json.get('balance') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	usuario_tiene_moneda.balance = json['balance']
	usuario_tiene_moneda.update()

	return jsonify({'usuario_tiene_moneda': usuario_tiene_moneda.json()})

# Delete
@app.route('/api/usuario_tiene_moneda/<id_usuario>/<id_moneda>', methods=['DELETE'])
def delete_usuario_tiene_moneda(id_usuario,id_moneda):
	usuario_tiene_moneda = UsuarioTieneMoneda.query.filter_by(id_usuario=id_usuario,id_moneda=id_moneda).first()
	if usuario_tiene_moneda is None:
		return jsonify({'message': 'Precio moneda does not exists'}), 404

	usuario_tiene_moneda.delete()

	return jsonify({'usuario_tiene_moneda': usuario_tiene_moneda.json() })

# ========== Usuario ============

# Create
@app.route('/api/usuario', methods=['POST'])
def create_usuario():
	json = request.get_json(force=True)

	if json.get('nombre') is None or json.get('correo') is None or json.get('contraseña') is None or json.get('pais') is None:
		return jsonify({'message':'El formato está mal'}), 400
	
	if json.get('apellido') is None:
		usuario = Usuario.create(json['nombre'],None,json['correo'],json['contraseña'],json['pais'])
	else:
		usuario = Usuario.create(json['nombre'],json['apellido'],json['correo'],json['contraseña'],json['pais'])

	print(type(usuario))
	return jsonify({'usuario': usuario.json()})

# Read
@app.route('/api/usuario', methods=['GET'])
def get_usuario():

	if(request.is_json):
		json = request.get_json(force=True)
		if json.get('id') is None:
			usuarios = [ usuario.json() for usuario in Usuario.query.all()]
		else:
			usuarios = Usuario.query.filter_by(id=json['id']).first().json()
	else:
		usuarios = [ usuario.json() for usuario in Usuario.query.all()]
	
	# if json.get('id') is None:
	# 	usuarios = [ usuario.json() for usuario in Usuario.query.all()]
	# else:
	# 	usuarios = Usuario.query.filter_by(id=id).first().json()
	# usuarios = [ usuario.json() for usuario in Usuario.query.all()]
	return jsonify({'usuario': usuarios})

@app.route('/api/usuario/<id>', methods=['GET'])
def get_usuario_id(id):
	usuario = Usuario.query.filter_by(id=id).first().json()
	# print(usuario.json())
	return jsonify({'usuario': usuario})

# Update
@app.route('/api/usuario/<id>', methods=['PUT'])
def update_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'message': 'usuario does not exists'}), 404
	
	json = request.get_json(force=True)
	if json.get('nombre') is None or json.get('correo') is None or json.get('pais') is None:
		return jsonify({'message': 'Bad request'}), 400
	
	usuario.nombre = json['nombre']
	if json.get('apellido') is not None:
		usuario.apellido = json['apellido']
	usuario.correo = json['correo']
	usuario.pais = json['pais']
	usuario.update()

	return jsonify({'usuario': usuario.json()})

# Delete
@app.route('/api/usuario/<id>', methods=['DELETE'])
def delete_usuario(id):
	usuario = Usuario.query.filter_by(id=id).first()
	if usuario is None:
		return jsonify({'message': 'Precio moneda does not exists'}), 404

	usuario.delete()

	return jsonify({'usuario': usuario.json() })


# =================================================================================================

@app.route('/api/consultas/1', methods=["GET"])
def all_users():
	json = request.get_json(force=True)
	if json.get('year') is None:
		return jsonify({'message': 'Bad request'}), 400

	year = json['year'] # 2000 2000/01/01 - 2000/12/31
	initialDate = datetime.datetime.strptime(str(year),'%Y')
	finalDate = datetime.datetime.strptime(str(year+1),'%Y') - datetime.timedelta(seconds=1)

	usuarios = Usuario.query.filter(Usuario.fecha_registro.between(initialDate,finalDate)).all()
	usuarios = [usuario.json() for usuario in usuarios]

	return jsonify({'usuarios':usuarios}), 200

@app.route('/api/consultas/2', methods=["GET"])
def all_accounts():
	json = request.get_json(force=True)
	if json.get('balance') is None:
		return jsonify({'message': 'Bad request'}), 400

	balance = json['balance']
	cuentas = CuentaBancaria.query.filter(CuentaBancaria.balance > balance).all()
	cuentas = [cuenta.json() for cuenta in cuentas]

	return jsonify({'cuentas':cuentas}), 200

@app.route('/api/consultas/3', methods=["GET"])
def all_in_pais():
	json = request.get_json(force=True)
	if json.get('pais') is None:
		return jsonify({'message': 'Bad request'}), 400

	pais = json['pais']

	usuarios = Usuario.query.filter(Usuario.pais == pais).all()
	usuarios = [usuario.json() for usuario in usuarios]

	return jsonify({'usuarios':usuarios}), 200

@app.route('/api/consultas/4', methods=["GET"])
def max_value():
	json = request.get_json(force=True)
	if json.get('moneda') is None:
		return jsonify({'message': 'Bad request'}), 400

	moneda = json['moneda']

	monedas = PrecioMoneda.query.filter(PrecioMoneda.id_moneda == moneda).order_by(PrecioMoneda.valor).limit(1)
	monedas = [moneda.json()['valor'] for moneda in monedas]
	return jsonify({'valor_maximo':monedas[0]}), 200

@app.route('/api/consultas/5', methods=["GET"])
def circulacion():
	json = request.get_json(force=True)
	if json.get('moneda') is None:
		return jsonify({'message': 'Bad request'}), 400

	moneda = json['moneda']

	monedas = UsuarioTieneMoneda.query.\
					with_entities(func.sum(UsuarioTieneMoneda.balance)).\
					filter(UsuarioTieneMoneda.id_moneda == moneda).all()
	
	monedas = monedas[0][0]
	return jsonify({'monedas':monedas}), 200




if __name__ == '__main__':
	app.run(debug=True)