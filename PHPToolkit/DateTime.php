<?php
namespace PHPToolkit;

class DateTime
{   
    protected $months = array(
        'en' => array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ),
        'es' => array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ),
    );
    
    protected $days = array(
        'en' => array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ),
        'es' => array(
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ),
    );
    
    /**
     * Obtener una lista de fechas, incluyendo las que se pasan como parámetro.
     * @param string|DateTime $date_from
     * @param string|DateTime $date_to
     * @param bool $include_from
     * @param bool $include_to
     * @param string $interval_type Tipos de intervalo de la clase DateInterval
     * @return array of DateTime objects
     */
    public function range($date_from, $date_to, $include_from, $include_to, $interval_type = 'P1D')
    {   
        if (is_string($date_from)) {
            $start = new DateTime($date_from);
        } else {
            $start = $date_from;
        }
        
        if (is_string($date_to)) {
            $end = new DateTime($date_to);
        } else {
            $end = $date_to;
        }
        
        if (!$include_from) {
            $start->modify('+1 day');
        }
               
        if ($include_to) {
            // DatePeriod no incluye la fecha final en el resultado, hay que
            // sumarle un día.
            $end->modify('+1 day');
        }

        $interval = new DateInterval($interval_type);        
        $period   = new DatePeriod($start, $interval, $end);

        // convertir el objeto DatePeriod en un array de objetos DateTime:
        $array = iterator_to_array($period); 
        
        return $array;
    }
    
    /**
     * Obtener una lista de fechas ubicadas entre las fechas límites.
     * Las fechas límites no se incluyen en el resultado.
     * @param string $date_from
     * @param string $date_to
     * @return array of DateTime
     */
    public function rangeBetween($date_from, $date_to)
    {
        return $this->range($date_from, $date_to, false, false);
    }
    
    /**
     * Obtener una lista de años ubicados entre los años mínimo y máximo.
     * Los años mínimo y máximo se incluyen en el resultado.
     * @param int $year_min
     * @param int $year_max
     * @param boolean $reversed
     * @return array
     */
    public function rangeYears($year_min, $year_max, $reversed = false)
    {
        if ($reversed) {
            $range = range($year_max, $year_min);
        } else {
            $range = range($year_min, $year_max);
        }
        
        // los años se usan como claves y como valores
        return array_combine($range, $range);
    }
    
    /**
     * Obtener una lista de nombres de meses, numerados del 1 al 12.
     * @param string $lang_code
     * @param boolean $abbreviated
     * @return array
     */
    public function getMonths($lang_code, $abbreviated = false)
    {        
        if ($abbreviated) {
            $list = array();
            foreach ($this->months[$lang_code] as $month_number => $month_name) {
                $list[$month_number] = substr($month_name, 0, 3);
            }
        } else {
            $list = $this->months[$lang_code];
        }
        
        return $list;
    }
    
    /**
     * Obtener el nombre de un mes en un determinado idioma.
     * @param int $month_number
     * @param string $lang_code
     * @param boolean $abbreviated
     * @return string
     */
    public function getMonthName($month_number, $lang_code, $abbreviated = false)
    {
        $m = sprintf('%02d', $month_number);
        $c = strtolower($lang_code);
        
        if ($abbreviated) {
            $name = substr($this->months[$c][$m], 0, 3);
        } else {
            $name = $this->months[$c][$m];
        }
        
        return $name;
    }
    
    /**
     * Obtener la lista de horas existentes durante un día.
     * @return array [ 0 .. 23 ]
     */
    public function getDayHours()
    {
        return range(0, 23);
    }
    
    /**
     * Obtener la lista de días de un mes en un determinado año.
     * @param int $year
     * @param int $month
     * @param $zero_based boolean Cuando es FALSE las claves serán iguales a los valores.
     * @return array [ 1 .. (28|29|30|31) ]
     */
    public function getMonthDays($year, $month, $zero_based = true)
    {
        $days = range(1, $this->getMonthLastDay($year, $month));
        
        if ($zero_based) {
            return $days;
        } else {
            $list = array();            
            foreach ($days as $day) {
                $d = sprintf('%02d', $day);
                $list[$d] = $d;
            }            
            return $list;             
        }
    }
    
    /**
     * Obtener el último día de un mes en un determinado año.
     * @param int $year
     * @param int $month
     * @return int
     */
    public function getMonthLastDay($year, $month)
    {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
    
    /**
     * Obtener una lista de números de días del 1 al 31, sin considerar año y mes.
     * @param $zero_based boolean Cuando es FALSE las claves serán iguales a los valores.
     * @return array [ 1 .. 31 ]
     */
    public function getDays($zero_based = true)
    {
        $days = range(1, 31);
        
        if ($zero_based) {
            return $days;
        } else {            
            $list = array();            
            foreach ($days as $day) {
                $d = sprintf('%02d', $day);
                $list[$d] = $d;
            }            
            return $list;            
        }        
    }
    
    /**
     * Obtener una lista de nombres de días, numerados del 1 al 7.
     * @param string $lang_code
     * @return array
     */
    public function getDayNames($lang_code)
    {
        return $this->days[$lang_code];
    }
    
    /**
     * Obtener el mes anterior a uno dado.
     * @param int $year
     * @param int $month
     * @return int
     */
    public function getPreviousMonth($year, $month)
    {
        $date = new DateTime($year . '-' . $month);
        $interval = new DateInterval('P1M');
        
        $date->sub($interval);
        
        return $date->format('m');
    }
    
    /**
     * Formatear una fecha DD/MM/YYYY como YYYY-MM-DD.
     * @param string $date
     * @return string
     */
    public function dateToIso($date)
    {
        return implode('-', array_reverse(explode('/', $date)));
    }
    
    /**
     * Comprobar si una fecha es válida.
     * @param string $date
     * @param string $format Formato que tiene la fecha de entrada.
     * @return boolean
     */
    public function isValidDate($date, $format = 'Y-m-d H:i:s')
    {        
        $d = DateTime::createFromFormat($format, $date);
        
        return $d && $d->format($format) === $date;
    }
}
