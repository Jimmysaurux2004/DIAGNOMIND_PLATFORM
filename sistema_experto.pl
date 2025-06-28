% ---------------------------------------------------
% SISTEMA EXPERTO PARA DIAGNÓSTICO DIFERENCIAL DE
% TDAH EN ADULTOS Y TRASTORNOS SIMILARES
%
% Requiere: SWI-Prolog
% Autor: [Tu nombre]
% Fecha: 2025-06-19
% ---------------------------------------------------

% ---------------------------
% Base de síntomas
% sintoma(ID, Descripción)
% ---------------------------
sintoma(1,  'Falta de concentración').
sintoma(2,  'Impulsividad').
sintoma(3,  'Hiperactividad o inquietud física').
sintoma(4,  'Preocupación excesiva difícil de controlar').
sintoma(5,  'Tristeza profunda o prolongada').
sintoma(6,  'Ciclos de energía alta y baja').
sintoma(7,  'Problemas crónicos para dormir').
sintoma(8,  'Dificultad para organizar tareas cotidianas').
sintoma(9,  'Procrastinación frecuente').
sintoma(10, 'Fatiga constante sin causa física').
sintoma(11, 'Dificultad para mantenerse sentado por mucho tiempo').
sintoma(12, 'Pérdida de interés o placer en casi todas las actividades').
sintoma(13, 'Irritabilidad persistente').
sintoma(14, 'Sensación de fracaso o culpa excesiva').
sintoma(15, 'Miedo a situaciones sociales o ser juzgado por otros').
sintoma(16, 'Pensamientos acelerados en ciclos').
sintoma(17, 'Necesidad de dormir muy poco con mucha energía').
sintoma(18, 'Dificultad para relajarse incluso en momentos tranquilos').

% ---------------------------
% Enfermedades:
% enfermedad(Nombre, [Síntomas], UmbralMínimo, SintomasClave)
% ---------------------------
enfermedad(tdah_adulto,
    [1,2,3,8,9,11,13,18],
    4,
    [2,3]).

enfermedad(ansiedad_generalizada,
    [1,4,7,10,13,15,18],
    4,
    [4]).

enfermedad(depresion_mayor,
    [1,5,7,9,10,12,14],
    5,
    [5,12]).

enfermedad(bipolar_II,
    [1,2,5,6,10,13,16,17],
    4,
    [6,17]).

enfermedad(insomnio_cronico,
    [1,5,7,10,14],
    4,
    [7]).

% ---------------------------
% Diagnóstico completo (múltiple)
% ---------------------------
diagnosticar(SintomasUsuario, Enfermedad) :-
    enfermedad(Enfermedad, SintomasEnf, Umbral, Clave),
    contar_coincidencias(SintomasUsuario, SintomasEnf, TotalCoinciden),
    TotalCoinciden >= Umbral,
    tiene_sintoma_clave(SintomasUsuario, Clave).

% Verifica si al menos 1 síntoma clave está presente
tiene_sintoma_clave(SintomasUsuario, [Clave|_]) :-
    member(Clave, SintomasUsuario), !.
tiene_sintoma_clave(SintomasUsuario, [_|Resto]) :-
    tiene_sintoma_clave(SintomasUsuario, Resto).

% Contador de síntomas coincidentes
contar_coincidencias([], _, 0).
contar_coincidencias([S|Resto], Lista, Total) :-
    member(S, Lista),
    contar_coincidencias(Resto, Lista, TotalR),
    Total is TotalR + 1.
contar_coincidencias([S|Resto], Lista, Total) :-
    \+ member(S, Lista),
    contar_coincidencias(Resto, Lista, Total).

% ---------------------------
% Mostrar todos los síntomas numerados
% ---------------------------
mostrar_sintomas :-
    writeln('--- Lista de síntomas disponibles ---'),
    forall(sintoma(ID, Desc), format('~w. ~w~n', [ID, Desc])).

% ---------------------------
% Ejecutar: muestra todos los diagnósticos posibles
% ---------------------------
ejecutar(SintomasID) :-
    findall((Enf, Coinc),
        (
            enfermedad(Enf, SintomasEnf, Umbral, Claves),
            contar_coincidencias(SintomasID, SintomasEnf, Coinc),
            Coinc >= Umbral,
            tiene_sintoma_clave(SintomasID, Claves)
        ),
        Diagnosticos),
    (
        Diagnosticos = [] ->
            writeln('No se detecta una condición con los síntomas ingresados.');
        (
            writeln('Diagnósticos ordenados por coincidencia:'),
            sort(2, @>=, Diagnosticos, Ordenados),
            imprimir_diagnosticos(Ordenados)
        )
    ).

imprimir_diagnosticos([]).
imprimir_diagnosticos([(Enf, Coinc)|R]) :-
    format('- ~w (coincidencias: ~w)~n', [Enf, Coinc]),
    imprimir_diagnosticos(R).

% ---------------------------
% Ejecutar y mostrar solo el diagnóstico más probable
% ---------------------------
ejecutar_mas_probable(SintomasID) :-
    findall((Enf, Coinc),
        (
            enfermedad(Enf, SintomasEnf, Umbral, Claves),
            contar_coincidencias(SintomasID, SintomasEnf, Coinc),
            Coinc >= Umbral,
            tiene_sintoma_clave(SintomasID, Claves)
        ),
        Diagnosticos),
    (
        Diagnosticos = [] ->
            writeln('No se detecta una condición con los síntomas ingresados.');
        Diagnosticos = Lista ->
            sort(2, @>=, Lista, [(EnfFinal, _) | _]),
            format('Diagnóstico más probable: ~w~n', [EnfFinal])
    ).
