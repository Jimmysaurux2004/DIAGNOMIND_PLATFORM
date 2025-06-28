% ---------------------------------------------------
% SISTEMA EXPERTO PARA DIAGNÓSTICO DIFERENCIAL DE
% TDAH EN ADULTOS Y TRASTORNOS SIMILARES
%
% Requiere: SWI-Prolog
% Autor: [Tu nombre]
% Fecha: 2025-06-19
% ---------------------------------------------------
:- set_prolog_flag(encoding, utf8).
:- dynamic tiene/1.

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
% enfermedad(NombreLegible, [Síntomas], UmbralMínimo, SintomasClave)
% ---------------------------
enfermedad("TDAH en adultos",
    [1,2,3,8,9,11,13,18],
    4,
    [2,3]).

enfermedad("Ansiedad generalizada",
    [1,4,7,10,13,15,18],
    4,
    [4]).

enfermedad("Depresion mayor",
    [1,5,7,9,10,12,14],
    5,
    [5,12]).

enfermedad("Trastorno bipolar II",
    [1,2,5,6,10,13,16,17],
    4,
    [6,17]).

enfermedad("Insomnio cronico",
    [1,5,7,10,14],
    4,
    [7]).

% ---------------------------
% Auxiliares
% ---------------------------

% Verifica si al menos 1 síntoma clave está presente
tiene_sintoma_clave([H|_], Claves) :- member(H, Claves), !.
tiene_sintoma_clave([_|T], Claves) :- tiene_sintoma_clave(T, Claves).

% Contador de coincidencias
contar_coincidencias([], _, 0).
contar_coincidencias([S|Resto], Lista, Total) :-
    member(S, Lista),
    contar_coincidencias(Resto, Lista, TotalR),
    Total is TotalR + 1.
contar_coincidencias([S|Resto], Lista, Total) :-
    \+ member(S, Lista),
    contar_coincidencias(Resto, Lista, Total).

% Limpia hechos dinámicos anteriores
limpiar :- retract(tiene(_)), fail.
limpiar.

% ---------------------------
% Regla principal: test/1
% llamada desde PHP: test([1,2,5,6,...])
% ---------------------------
test(SintomasID) :-
    limpiar,
    lista(SintomasID),
    ejecutar_mas_probable(SintomasID).

% Inserta síntomas dinámicamente
lista([]).
lista([H|T]) :- assert(tiene(H)), lista(T).

% Ejecuta y muestra solo el diagnóstico más probable
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
            writeln('ninguno');
        sort(2, @>=, Diagnosticos, [(EnfFinal, _) | _]),
        writeln(EnfFinal)
    ).
