<?php


class rsFlashMessage
{
    const FLASH = 'FLASH_MESSAGES';

    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    /**
     * Crear un mensaje flash
     *
     * @param string $name
     * @param string $message
     * @param string $type
     * @return void
     */
    function create_flash_message(string $name, string $message, string $type): string
    {
        // si ya existe un mensaje flash , lo elimina
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
        // creal el nuevo mensaje en variable de sesion
        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
        return "";
    }


    /**
     * Dar formato al emsaje segun type
     *
     * @param array $flash_message
     * @return string
     */
    function format_flash_message(array $flash_message): string
    {
        return sprintf(
            '<div class="alert alert-%s">%s</div>',
            $flash_message['type'],
            $flash_message['message']
        );
    }

    /**Mostrar el mensaje 
     *
     * @param string $name
     * @return void
     */
    function display_flash_message(string $name): string
    {
        if (!isset($_SESSION[self::FLASH][$name])) {
            return "";
        }

        // obetner el mensaje de la variable de sesion
        $flash_message = $_SESSION[self::FLASH][$name];

        // borrar el mensaje
        unset($_SESSION[self::FLASH][$name]);

        // mostrar el mensaje
        return self::format_flash_message($flash_message);
    }

    /** Mostrar todos los mensajes
     *
     * @return void
     */
    function display_all_flash_messages(): array
    {
        $returnString = array();
        if (!isset($_SESSION[self::FLASH])) {
            return array();
        }

        // obtener todos los mensajes
        $flash_messages = $_SESSION[self::FLASH];

        // borar todos los mensajes
        unset($_SESSION[self::FLASH]);

        // mostrar todos los mensajes
        foreach ($flash_messages as $flash_message) {
            $returnString .= self::format_flash_message($flash_message);
        }
        return $returnString;
    }

    /**
     * Setear un mensaje flash
     *
     * @param string $name
     * @param string $message
     * @param string $type (error, warning, info, success)
     * @return void
     */
    function flash(string $name = '', string $message = '', string $type = ''): string
    {
        $returnString = "";
        if ($name !== '' && $message !== '' && $type !== '') {
            // Si se proporcionan valores para $name, $message y $type, la función llama a self::create_flash_message($name, $message, $type). Esto sugiere que crea una nueva “flash message” con los detalles dados.
            $returnString = self::create_flash_message($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === '') {
            // Si se proporciona solo $name (sin $message ni $type), la función llama a self::display_flash_message($name). Esto implica que muestra la “flash message” con el nombre especificado.
            $returnString = self::display_flash_message($name);
        } elseif ($name === '' && $message === '' && $type === '') {
            // Si no se proporcionan valores para ninguno de los parámetros, la función llama a self::display_all_flash_messages(). Esto probablemente muestra todas las “flash messages” almacenadas.
            $returnString = self::display_all_flash_messages();
        } 
        return $returnString;
    }
}
